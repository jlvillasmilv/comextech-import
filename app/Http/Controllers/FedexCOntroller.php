<?php

namespace App\Http\Controllers;

//use Illuminate\Http\Request;

use FedEx\RateService\Request;

use FedEx\RateService\ComplexType;

use FedEx\RateService\SimpleType;

use Illuminate\Support\Facades\Http;

class FedexCOntroller extends Controller
{
    

    
  public function test()
  {

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
                  "value": "740561073"
                },
                "requestedShipment": {
                  "shipper": {
                    "address": {
                      "postalCode": 65247,
                      "countryCode": "US"
                    }
                  },
                  "recipient": {
                    "address": {
                      "postalCode": 75063,
                      "countryCode": "US"
                    }
                  },
                  "pickupType": "DROPOFF_AT_FEDEX_LOCATION",
                  "serviceType": "PRIORITY_OVERNIGHT",
                  "rateRequestType": [
                    "LIST",
                    "ACCOUNT"
                  ],
                  "requestedPackageLineItems": [
                    {
                      "weight": {
                        "units": "KG",
                        "value": 60
                      },
                      "dimensions": {
                        "length": 30,
                        "width": 30,
                        "height": 40,
                        "units": "IN"
                      }
                    }
                  ]
                }
              }';

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
