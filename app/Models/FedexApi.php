<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;

use FedEx\RateService\Request;
use FedEx\RateService\ComplexType;
use FedEx\RateService\SimpleType;

use FedEx\TrackService\Request as tRequest;
use FedEx\TrackService\ComplexType as tComplexType;
use FedEx\TrackService\SimpleType as tSimpleType;

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
      $shipper_street_lines = $data['origin_address'];

      $recipient_postal_code  = $data['origin_postal_code'];
      $recipient_country_code = $data['dest_ctry_code'];
      $recipient_city         = $data['dest_locality'];
      $recipient_street_lines = $data['dest_address'];
      

       // if favorite address origin is true find en storage
      if($data['fav_origin_address']){

        $address = SupplierAddress::where('id', $data['origin_address'])->firstOrFail();

        $shipper_postal_code = $address->postal_code;
        $shipper_country_code = $address->country_code;
        $shipper_city = $address->locality;

      }
      
      // if favorite address dest is true find en storage
      if($data['fav_dest_address']){

        $address = CompanyAddress::where('id', $data['dest_address'])->firstOrFail();

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
      $rateRequest->Version->Major = 31;
      $rateRequest->Version->Minor = 0;
      $rateRequest->Version->Intermediate = 0;

      $rateRequest->ReturnTransitAndCommit = true;

      // $rateRequest->RequestedShipment->ServiceType = SimpleType\ServiceType::_INTERNATIONAL_PRIORITY;

      // if(($data['dataLoad'][0]['weight'] > 68 && $data['dataLoad'][0]['weight_units'] == 'KG') || ($data['dataLoad'][0]['weight'] > 150 && $data['dataLoad'][0]['weight_units'] == 'LB')){ 
      //   $rateRequest->RequestedShipment->ServiceType = SimpleType\ServiceType::_INTERNATIONAL_PRIORITY_FREIGHT;
      // }

      $shipDate  = is_null($data['estimated_date']) ? new \DateTime() : new \DateTime($data['estimated_date']);

      //shipper
      $rateRequest->RequestedShipment->PreferredCurrency = 'USD';
      $rateRequest->RequestedShipment->setShipTimestamp($shipDate->format('c'));
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
     //dd($rateReply->RateReplyDetails);
      if (!empty($rateReply->RateReplyDetails)) {
          foreach ($rateReply->RateReplyDetails as $rateReplyDetail) {

              $response['ServiceType'] = $rateReplyDetail->ServiceType;
              $response['DeliveryTimestamp'] = empty($rateReplyDetail->DeliveryTimestamp) ? date('c',strtotime($data['estimated_date']. ' + 2 day')) :  $rateReplyDetail->DeliveryTimestamp;
             
              if (!empty($rateReplyDetail->RatedShipmentDetails)) {

                  foreach ($rateReplyDetail->RatedShipmentDetails as $ratedShipmentDetail) {
                    //var_dump('<pre>'.$ratedShipmentDetail->ShipmentRateDetail->RateType . ": " . $ratedShipmentDetail->ShipmentRateDetail->TotalNetCharge->Amount. ": " .$ratedShipmentDetail->ShipmentRateDetail->TotalNetCharge->Currency.'</pre>');
                      $response[$ratedShipmentDetail->ShipmentRateDetail->RateType ] = 
                      [
                        'TotalNetCharge'  => round($ratedShipmentDetail->ShipmentRateDetail->TotalNetCharge->Amount, 2),
                        'TotalBaseCharge' =>  round($ratedShipmentDetail->ShipmentRateDetail->TotalBaseCharge->Amount, 2),
                        'TotalFreightDiscounts' => round($ratedShipmentDetail->ShipmentRateDetail->TotalFreightDiscounts->Amount, 2),
                        'Surcharges' => $ratedShipmentDetail->ShipmentRateDetail->Surcharges,
                      ]; 
                      
                  }

              }
             
          }
          return $response; 
      }

      return $rateReply;

  }

  public static function tracking($TrackingNumber)
  {
    
    $trackingId1 = $TrackingNumber;           

    $trackRequest = new tComplexType\TrackRequest();

    // User Credential
    $trackRequest->WebAuthenticationDetail->UserCredential->Key =  env('FEDEX_KEY');
    $trackRequest->WebAuthenticationDetail->UserCredential->Password = env('FEDEX_PASSWORD');

    //Client Detail
    $trackRequest->ClientDetail->AccountNumber = env('FEDEX_ACCOUNT_NUMBER');
    $trackRequest->ClientDetail->MeterNumber   = env('FEDEX_METER_NUMBER');

    // Version
    $trackRequest->Version->ServiceId = 'trck';
    $trackRequest->Version->Major = 20;
    $trackRequest->Version->Intermediate = 0;
    $trackRequest->Version->Minor = 0;

    $trackRequest->CustomerTransactionId = 'create pickup request example';
    $trackRequest->TransactionDetail->Localization->LanguageCode = 'ES';
    $trackRequest->TransactionDetail->Localization->LocaleCode = 'ES';
    
    // Track 2 shipments
    $trackRequest->SelectionDetails = [new tComplexType\TrackSelectionDetail(), new tComplexType\TrackSelectionDetail()];

    // For get all events
    $trackRequest->ProcessingOptions = [tSimpleType\TrackRequestProcessingOptionType::_INCLUDE_DETAILED_SCANS];

    // Track shipment 1
    $trackRequest->SelectionDetails[0]->PackageIdentifier->Value = $trackingId1;
    $trackRequest->SelectionDetails[0]->PackageIdentifier->Type = tSimpleType\TrackIdentifierType::_TRACKING_NUMBER_OR_DOORTAG;

    $request = new tRequest();
    try {
        $request->getSoapClient()->__setLocation(Request::PRODUCTION_URL);
        $trackReply = $request->getTrackReply($trackRequest);


        if (!empty($trackReply->CompletedTrackDetails)) {

          return $trackReply->CompletedTrackDetails[0]->TrackDetails[0];

        }
      
    } catch (\Exception $e) {
        echo $e->getMessage();
        return $request->getSoapClient()->__getLastResponse();
    }


  }

}
