<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;

class FedexApi extends Model
{
    use HasFactory;

    public function rateApi($load, $transport = null)
    {
        $package_line_items = array();
        foreach ($load as $key => $item) {

            $package = [
                "weight" => [ "units" => $item['weight_units'],  "value" => $item['weight']],
              //  "dimensions" => ["length" => $item['length'],  "width" => $item['width'], "height" => $item['high'], "units" => "IN"] 
            ];
            array_push($package_line_items, $package );
        }

        $shipper_postal_code = $transport->origin_postal_code;
        $shipper_country_code = $transport->origin_ctry_code;

        if($transport->fav_address_origin){

          $address = SupplierAddress::where('id', $transport->address_origin)->firstOrFail();

          $shipper_postal_code = $address->postal_code;
          $shipper_country_code = $address->country_code;

        }

        $recipient_postal_code = $transport->origin_postal_code;
        $recipient_country_code = $transport->dest_ctry_code;

        if($transport->fav_dest_address){

          $address = CompanyAddress::where('id', $transport->address_destination)->firstOrFail();

          $recipient_postal_code = $address->postal_code;
          $recipient_country_code = $address->country->code;
          
        }

        //dd(json_encode($shipper_postal_code));

      //generate token
      $credential = 'grant_type=client_credentials&client_id='.env('FEDEX_KEY').'&client_secret='.env('FEDEX_PASSWORD');
   
      $httpResponse = Http::withBody($credential, 'application/x-www-form-urlencoded')
      ->withHeaders([
        'Content-Type' => 'application/x-www-form-urlencoded'
      ])->post(env('FEDEX_OAUTH_URL','https://apis-sandbox.fedex.com/oauth/token'));
  
      $token = json_decode($httpResponse->body());
  
      if(isset($token->access_token)){
  
        $body = '{
          "accountNumber": {
            "value": "'.env('FEDEX_ACCOUNT_NUMBER').'"
          },
          "requestedShipment": {
            "shipper": {
              "address": {
                "postalCode": '.$shipper_postal_code.',
                "countryCode": "'.$shipper_country_code.'",
                "residential":false
              }
            },
            "recipient": {
              "address": {
                
                "postalCode": 755000,
                "countryCode": "'.$recipient_country_code.'"
              }
            },
            "pickupType": "DROPOFF_AT_FEDEX_LOCATION",
            "serviceType": "INTERNATIONAL_PRIORITY",
            "preferredCurrency":"USD",
            "rateRequestType": ["LIST","ACCOUNT"],
            "shipDateStamp":"2021-10-06",
            "requestedPackageLineItems": '.json_encode($package_line_items).'
            }
        }';

        //dd($body);

            //     "postalCode": '.$shipper_postal_code.',
            //     "countryCode": "'.$shipper_country_code.'",
            //     "residential":false
            //   }
            // },
            // "recipient": {
            //   "address": {
                
            //     "postalCode": '.$recipient_postal_code.',
            //     "countryCode": "'.$recipient_country_code.'"
            //   }

                // $example = '{
                //     "accountNumber": {
                //       "value": "XXXXX7364"
                //     },
                //     "requestedShipment": {
                //       "shipper": {
                //         "address": {
                //           "postalCode": 8099,
                //           "countryCode": "CH"
                //         }
                //       },
                //       "recipient": {
                //         "address": {
                //           "postalCode": 2116,
                //           "countryCode": "AU"
                //         }
                //       },
                //       "shipDateStamp": "2020-07-03",
                //       "pickupType": "DROPOFF_AT_FEDEX_LOCATION",
                //       "serviceType": "INTERNATIONAL_PRIORITY",
                //       "rateRequestType": [
                //         "LIST",
                //         "ACCOUNT"
                //       ],
                //       "customsClearanceDetail": {
                //         "dutiesPayment": {
                //           "paymentType": "SENDER",
                //           "payor": {}
                //         },
                //         "commodities": [
                //           {
                //             "description": "Camera",
                //             "quantity": 1,
                //             "quantityUnits": "PCS",
                //             "weight": {
                //               "units": "KG",
                //               "value": 11
                //             },
                //             "customsValue": {
                //               "amount": 100,
                //               "currency": "SFR"
                //             }
                //           }
                //         ]
                //       },
                //       "requestedPackageLineItems": [
                //         {
                //           "groupPackageCount": 2,
                //           "weight": {
                //             "units": "KG",
                //             "value": 1
                //           }
                //         },
                //         {
                //           "groupPackageCount": 3,
                //           "weight": {
                //             "units": "KG",
                //             "value": 10
                //           }
                //         }
                //       ]
                //     }
                //   }';

              $httpResponse = Http::withToken($token->access_token)
                  ->withBody($body,'application/json')
                  ->withHeaders([
                      'Authorization' => 'Bearer ',
                      'X-locale' => 'en_US',
                      'Content-Type' => 'application/json'                
                  ])->post(env('FEDEX_RATE_URL','https://apis-sandbox.fedex.com/rate/v1/rates/quotes'));
  
                  dd(json_decode($httpResponse->body()));
        
      } 
  
    }
}
