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

  public function rateApi($data)
  {
    // 
     
      $shipper_postal_code  = $data['origin_postal_code'];
      $shipper_country_code = $data['origin_ctry_code'];
      $shipper_city         = $data['origin_locality'];
      $shipper_street_lines = $data['address_origin'];

      $recipient_postal_code  = $data['origin_postal_code'];
      $recipient_country_code = $data['dest_ctry_code'];
      $recipient_city         = $data['dest_locality'];
      $recipient_street_lines = $data['address_destination'];
      

       // if favorite address origin is true find en storage
      if($data['fav_address_origin']){

        $address = SupplierAddress::where('id', $data['address_origin'])->firstOrFail();

        $shipper_postal_code = $address->postal_code;
        $shipper_country_code = $address->country_code;
        $shipper_city = $address->locality;

      }
      
      // if favorite address dest is true find en storage
      if($data['fav_dest_address']){

        $address = CompanyAddress::where('id', $data['address_destination'])->firstOrFail();

        $recipient_postal_code = $address->postal_code;
        $recipient_country_code = $address->country->code;
        $recipient_city = $address->locality;
          
      }

      $rateRequest = new ComplexType\RateRequest();

      //authentication & client details
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

      $rateRequest->RequestedShipment->ServiceType = SimpleType\ServiceType::_INTERNATIONAL_PRIORITY;

      if(($data['dataLoad'][0]['weight'] > 68 && $data['dataLoad'][0]['weight_units'] == 'KG') || ($data['dataLoad'][0]['weight'] > 150 && $data['dataLoad'][0]['weight_units'] == 'LB')){ 
        $rateRequest->RequestedShipment->ServiceType = SimpleType\ServiceType::_INTERNATIONAL_PRIORITY_FREIGHT;
      }

      $shipDate  = new \DateTime();
      $ship_date = is_null($data['estimated_date']) ? $shipDate->format('c') : date('c',strtotime($data['estimated_date'])) ;
      
      //shipper
      $rateRequest->RequestedShipment->PreferredCurrency = 'USD';
      $rateRequest->RequestedShipment->ShipTimestamp =  $ship_date;
      $rateRequest->RequestedShipment->Shipper->Address->StreetLines = [ $shipper_street_lines];
      $rateRequest->RequestedShipment->Shipper->Address->City = $shipper_city;
      $rateRequest->RequestedShipment->Shipper->Address->PostalCode = $shipper_postal_code;
      $rateRequest->RequestedShipment->Shipper->Address->CountryCode = $shipper_country_code;

      //recipient
      $rateRequest->RequestedShipment->Recipient->Address->StreetLines = [$recipient_street_lines];
      $rateRequest->RequestedShipment->Recipient->Address->City = $recipient_city;
      $rateRequest->RequestedShipment->Recipient->Address->PostalCode = $recipient_postal_code;
      $rateRequest->RequestedShipment->Recipient->Address->CountryCode = $recipient_country_code;

      //shipping charges payment
      $rateRequest->RequestedShipment->ShippingChargesPayment->PaymentType = SimpleType\PaymentType::_SENDER;

      //rate request types
      $rateRequest->RequestedShipment->RateRequestTypes = [SimpleType\RateRequestType::_PREFERRED, SimpleType\RateRequestType::_LIST];
      
      $rateRequest->RequestedShipment->PackageCount = count($data['dataLoad']);
     
      // //create package line items
      $line_items = array();
      for ($x = 1; $x <= count($data['dataLoad']); $x++)
      {
        $line_items[] = new ComplexType\RequestedPackageLineItem();
      }

      $rateRequest->RequestedShipment->RequestedPackageLineItems = $line_items;
    
      foreach ($data['dataLoad'] as $key => $item) {
         
        $rateRequest->RequestedShipment->RequestedPackageLineItems[$key]->Weight->Value = $item['weight'];
        $rateRequest->RequestedShipment->RequestedPackageLineItems[$key]->Weight->Units = $item['weight_units'] == 'KG' ? SimpleType\WeightUnits::_KG : SimpleType\WeightUnits::_LB;
        $rateRequest->RequestedShipment->RequestedPackageLineItems[$key]->Dimensions->Length = $item['length'];
        $rateRequest->RequestedShipment->RequestedPackageLineItems[$key]->Dimensions->Width  = $item['width'];
        $rateRequest->RequestedShipment->RequestedPackageLineItems[$key]->Dimensions->Height = $item['height'];
        $rateRequest->RequestedShipment->RequestedPackageLineItems[$key]->Dimensions->Units  = $item['length_unit'] == 'CM' ?  SimpleType\LinearUnits::_CM : SimpleType\LinearUnits::_IN; 
        $rateRequest->RequestedShipment->RequestedPackageLineItems[$key]->GroupPackageCount = 1;
      }

      $rateServiceRequest = new Request();
      $rateServiceRequest->getSoapClient()->__setLocation(Request::PRODUCTION_URL); //use production URL
      $rateReply = $rateServiceRequest->getGetRatesReply($rateRequest); 

      $response = array();
      //dd($rateReply);
      if (!empty($rateReply->RateReplyDetails)) {
          foreach ($rateReply->RateReplyDetails as $rateReplyDetail) {
             // var_dump($rateReplyDetail->ServiceType);
              $response['ServiceType'] = $rateReplyDetail->ServiceType;
              $response['DeliveryTimestamp'] = $rateReplyDetail->DeliveryTimestamp;

              if (!empty($rateReplyDetail->RatedShipmentDetails)) {

                  foreach ($rateReplyDetail->RatedShipmentDetails as $ratedShipmentDetail) {
                    //var_dump('<pre>'.$ratedShipmentDetail->ShipmentRateDetail->RateType . ": " . $ratedShipmentDetail->ShipmentRateDetail->TotalNetCharge->Amount. ": " .$ratedShipmentDetail->ShipmentRateDetail->TotalNetCharge->Currency.'</pre>');
                      $response[$ratedShipmentDetail->ShipmentRateDetail->RateType ] = 
                      [
                        'TotalNetCharge'  => $ratedShipmentDetail->ShipmentRateDetail->TotalNetCharge->Amount,
                        'TotalBaseCharge' => $ratedShipmentDetail->ShipmentRateDetail->TotalBaseCharge->Amount,
                        'TotalBaseCharge' => $ratedShipmentDetail->ShipmentRateDetail->TotalBaseCharge->Amount,
                        'TotalFreightDiscounts' => $ratedShipmentDetail->ShipmentRateDetail->TotalFreightDiscounts->Amount,
                        'Surcharges' => $ratedShipmentDetail->ShipmentRateDetail->Surcharges,
                      ]; 
                      
                  }

              }
             
          }
         
          return $response; 
      }

      return $rateReply;

  }

}
