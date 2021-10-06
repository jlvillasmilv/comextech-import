<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;

use FedEx\RateService\Request;

use FedEx\RateService\ComplexType;

use FedEx\RateService\SimpleType;

class FedexApi extends Model
{
    use HasFactory;

  /**
   * This test will send the same test data as in FedEx's documentation:
   * /php/RateAvailableServices/RateAvailableServices.php5
  */

  //remember to copy credentials as  'FEDEX_KEY', 'FEDEX_PASSWORD', 'FEDEX_ACCOUNT_NUMBER', and 'FEDEX_METER_NUMBER' .env

  public function rateApi($load, $transport = null)
  {

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


      $rateRequest = new ComplexType\RateRequest();

      $rateRequest->WebAuthenticationDetail->UserCredential->Key = env('FEDEX_KEY');
      $rateRequest->WebAuthenticationDetail->UserCredential->Password = env('FEDEX_PASSWORD');
      $rateRequest->ClientDetail->AccountNumber = env('FEDEX_ACCOUNT_NUMBER');
      $rateRequest->ClientDetail->MeterNumber = env('FEDEX_METER_NUMBER');

      $rateRequest->TransactionDetail->CustomerTransactionId = 'testing rate service request';
      
      //version
      $rateRequest->Version->ServiceId = 'crs';
      $rateRequest->Version->Major = 28;
      $rateRequest->Version->Minor = 0;
      $rateRequest->Version->Intermediate = 0;

      $rateRequest->ReturnTransitAndCommit = true;
      $rateRequest->RequestedShipment->ServiceType = (new SimpleType\ServiceType(SimpleType\ServiceType::_INTERNATIONAL_ECONOMY_FREIGHT));
      

    //shipper
    $rateRequest->RequestedShipment->PreferredCurrency = 'USD';
    // $rateRequest->RequestedShipment->Shipper->Address->StreetLines = ['10 Fed Ex Pkwy'];
    // $rateRequest->RequestedShipment->Shipper->Address->City = 'Memphis';
    // $rateRequest->RequestedShipment->Shipper->Address->StateOrProvinceCode = 'TN';
    $rateRequest->RequestedShipment->Shipper->Address->PostalCode = $shipper_postal_code;
    $rateRequest->RequestedShipment->Shipper->Address->CountryCode = $shipper_country_code;

    //recipient
     $rateRequest->RequestedShipment->Recipient->Address->StreetLines = ['Augusto leguia'];
     $rateRequest->RequestedShipment->Recipient->Address->City = 'Las Condes';
     //$rateRequest->RequestedShipment->Recipient->Address->StateOrProvinceCode = 'RM';
     //$rateRequest->RequestedShipment->Recipient->Address->PostalCode = $recipient_postal_code;
     $rateRequest->RequestedShipment->Recipient->Address->CountryCode = 'CL';

      $rateRequest->RequestedShipment->ShippingChargesPayment->PaymentType = SimpleType\PaymentType::_SENDER;

      $rateRequest->RequestedShipment->RateRequestTypes = [SimpleType\RateRequestType::_PREFERRED, SimpleType\RateRequestType::_LIST];

      $rateRequest->RequestedShipment->PackageCount = 2;

      $rateRequest->RequestedShipment->RequestedPackageLineItems = [new ComplexType\RequestedPackageLineItem(), new ComplexType\RequestedPackageLineItem()];

      $rateRequest->RequestedShipment->RequestedPackageLineItems[0]->Weight->Value = 150;
      $rateRequest->RequestedShipment->RequestedPackageLineItems[0]->Weight->Units = SimpleType\WeightUnits::_KG;
      $rateRequest->RequestedShipment->RequestedPackageLineItems[0]->Dimensions->Length = 10;
      $rateRequest->RequestedShipment->RequestedPackageLineItems[0]->Dimensions->Width = 10;
      $rateRequest->RequestedShipment->RequestedPackageLineItems[0]->Dimensions->Height = 3;
      $rateRequest->RequestedShipment->RequestedPackageLineItems[0]->Dimensions->Units = SimpleType\LinearUnits::_IN;
      $rateRequest->RequestedShipment->RequestedPackageLineItems[0]->GroupPackageCount = 1;

      $rateRequest->RequestedShipment->RequestedPackageLineItems[1]->Weight->Value = 150;
      $rateRequest->RequestedShipment->RequestedPackageLineItems[1]->Weight->Units = SimpleType\WeightUnits::_KG;
      $rateRequest->RequestedShipment->RequestedPackageLineItems[1]->Dimensions->Length = 20;
      $rateRequest->RequestedShipment->RequestedPackageLineItems[1]->Dimensions->Width = 20;
      $rateRequest->RequestedShipment->RequestedPackageLineItems[1]->Dimensions->Height = 10;
      $rateRequest->RequestedShipment->RequestedPackageLineItems[1]->Dimensions->Units = SimpleType\LinearUnits::_IN;
      $rateRequest->RequestedShipment->RequestedPackageLineItems[1]->GroupPackageCount = 1;

      $rateServiceRequest = new Request();
      //$rateServiceRequest->getSoapClient()->__setLocation(Request::TESTING_URL); 
      $rateServiceRequest->getSoapClient()->__setLocation(Request::PRODUCTION_URL); //use production URL
      $rateReply = $rateServiceRequest->getGetRatesReply($rateRequest); 

      if (!empty($rateReply->RateReplyDetails)) {
          foreach ($rateReply->RateReplyDetails as $rateReplyDetail) {
              var_dump($rateReplyDetail->ServiceType);
              if (!empty($rateReplyDetail->RatedShipmentDetails)) {
                  foreach ($rateReplyDetail->RatedShipmentDetails as $ratedShipmentDetail) {
                      var_dump($ratedShipmentDetail->ShipmentRateDetail->RateType . ": " . $ratedShipmentDetail->ShipmentRateDetail->TotalNetCharge->Amount);
                  }
              }
              echo "<hr />";
          }
      }
      dd($rateReply );
      //var_dump($rateReply);

  }

    // public function rateApi($load, $transport = null)
    // {
    //     $package_line_items = array();
    //     foreach ($load as $key => $item) {

    //         $package = [
    //             "weight" => [ "units" => $item['weight_units'],  "value" => $item['weight']],
    //           //  "dimensions" => ["length" => $item['length'],  "width" => $item['width'], "height" => $item['high'], "units" => "IN"] 
    //         ];
    //         array_push($package_line_items, $package );
    //     }

    //     $shipper_postal_code = $transport->origin_postal_code;
    //     $shipper_country_code = $transport->origin_ctry_code;

    //     if($transport->fav_address_origin){

    //       $address = SupplierAddress::where('id', $transport->address_origin)->firstOrFail();

    //       $shipper_postal_code = $address->postal_code;
    //       $shipper_country_code = $address->country_code;

    //     }

    //     $recipient_postal_code = $transport->origin_postal_code;
    //     $recipient_country_code = $transport->dest_ctry_code;

    //     if($transport->fav_dest_address){

    //       $address = CompanyAddress::where('id', $transport->address_destination)->firstOrFail();

    //       $recipient_postal_code = $address->postal_code;
    //       $recipient_country_code = $address->country->code;
          
    //     }

    //     //dd(json_encode($shipper_postal_code));

    //   //generate token
    //   $credential = 'grant_type=client_credentials&client_id='.env('FEDEX_KEY').'&client_secret='.env('FEDEX_PASSWORD');
   
    //   $httpResponse = Http::withBody($credential, 'application/x-www-form-urlencoded')
    //   ->withHeaders([
    //     'Content-Type' => 'application/x-www-form-urlencoded'
    //   ])->post(env('FEDEX_OAUTH_URL','https://apis-sandbox.fedex.com/oauth/token'));
  
    //   $token = json_decode($httpResponse->body());
  
    //   if(isset($token->access_token)){
  
    //     $body = '{
    //       "accountNumber": {
    //         "value": "'.env('FEDEX_ACCOUNT_NUMBER').'"
    //       },
    //       "requestedShipment": {
    //         "shipper": {
    //           "address": {
    //             "postalCode": '.$shipper_postal_code.',
    //             "countryCode": "'.$shipper_country_code.'",
    //             "residential":false
    //           }
    //         },
    //         "recipient": {
    //           "address": {
                
    //             "postalCode": 755000,
    //             "countryCode": "'.$recipient_country_code.'"
    //           }
    //         },
    //         "pickupType": "DROPOFF_AT_FEDEX_LOCATION",
    //         "serviceType": "INTERNATIONAL_PRIORITY",
    //         "preferredCurrency":"USD",
    //         "rateRequestType": ["LIST","ACCOUNT"],
    //         "shipDateStamp":"2021-10-06",
    //         "requestedPackageLineItems": '.json_encode($package_line_items).'
    //         }
    //     }';

    //           $httpResponse = Http::withToken($token->access_token)
    //               ->withBody($body,'application/json')
    //               ->withHeaders([
    //                   'Authorization' => 'Bearer ',
    //                   'X-locale' => 'en_US',
    //                   'Content-Type' => 'application/json'                
    //               ])->post(env('FEDEX_RATE_URL','https://apis-sandbox.fedex.com/rate/v1/rates/quotes'));
  
    //               dd(json_decode($httpResponse->body()));
        
    //   } 
  
    // }
}
