<?php

namespace App\Models\services;

use Illuminate\Database\Eloquent\Model;
use App\Models\{CompanyAddress, SupplierAddress};

class DHL extends Model
{
    public function quoteApi($data)
    {
        $from_postal_code  = is_null($data['origin_postal_code']) ? '0' : $data['origin_postal_code'] ;
        $from_country_code = $data['origin_ctry_code'];
        $from_city         = $data['origin_locality'];
        $from_street_lines = $data['origin_address'];
  
        $to_postal_code  = $data['origin_postal_code'];
        $to_country_code = $data['dest_ctry_code'];
        $to_city         = $data['dest_locality'];
        $to_street_lines = $data['dest_address'];
        
         // if favorite address origin is true find en storage
        if($data['fav_origin_address']){
  
          $address = SupplierAddress::where('id', $data['origin_address'])->firstOrFail();
  
          $from_postal_code = $address->postal_code;
          $from_country_code = $address->country_code;
          $from_city = $address->locality;
  
        }
        
        // if favorite address dest is true find en storage
        if($data['fav_dest_address']){
  
          $address = CompanyAddress::where('id', $data['dest_address'])->firstOrFail();
  
          $to_postal_code = $address->postal_code;
          $to_country_code = $address->country->code;
          $to_city = $address->locality;
            
        }

        $shipDate  = is_null($data['estimated_date']) ? new \DateTime() : new \DateTime($data['estimated_date']);

        $Pieces = array();
        foreach ($data['dataLoad'] as $key => $item) {

            $pieces[] = [
                "height" => $item['height'],
                "width" => $item['width'] ,
                "depth" => $item['length'],
                "weight" => $item['weight']
            ];
         
          }

        $quote = new Calls\GetQuote();
        $quote->declaredValue(1)
        ->reference("1234567890123456789012345678901")
        ->currency("USD")
        ->shipDate($shipDate->format('Y-m-d'))
        ->fromCountryCode($from_country_code)
        ->fromPostalCode($from_postal_code)
        ->fromCity($from_city)
        ->toCountryCode($to_country_code)
        ->toPostalCode($to_postal_code)
        ->toCity($to_city)
        ->weightUnit($data['dataLoad'][0]['weight_units'])
        ->dimensionUnit($data['dataLoad'][0]['length_unit'])
        ->setPieces($pieces);

        return $quote->getResponse();

    }

    public static function Tracking($tracking_number)
    {
      try {
        $quote = new Calls\GetTracking();
        $quote->reference("1234567890123456789012345678901");
        $quote->setTrackingNumber($tracking_number);

        $api_response = $quote->getResponse();

        $objJsonDocument = json_encode($api_response);
        $arrOutput = json_decode($objJsonDocument, TRUE);

        dd($arrOutput['AWBInfo']);

        $response = array();

        if (!empty($arrOutput['ShipmentInfo'])) {

           $response['TrackingNumber'] = $api_response['AWBInfo']['Status']['ActionStatus'];
           $response['StatusDetail']   = $api_response['AWBInfo']['AWBNumber'];
          // $response['ShipperAddress'] = $api_response-> ;
          // $response['DatesOrTimes']   = $api_response-> 
          // $response['DestinationAddress'] = $api_response-> ;
  
          return $response; 
        }

        // if (!empty($api_response->AWBInfo)) {

        //   $response['TrackingNumber'] = $abi->AWBInfo;
        //   $response['AWBInfo']   =  $api_response->AWBInfo;
          
        //   return $response; 
        // }

       

      } catch (\Exception $e) {
          return response()->json(['message' => "The given data was invalid.",
           'errors' => ['dhl' => $e->getMessage()]], 422);
         
      }
      //  // dd($quote->getResponse()->AWBInfo);
        
      //   $tmp_awb = (string)$quote->getResponse()->AWBNumber;
      //   $td['awb'] = $tmp_awb;
        
      //   $td['res']['status'] = (string)$abi->Status->ActionStatus;
        
      //   $td['event']['time']['date'] = (string)$abi->ShipmentInfo->ShipmentEvent->Date;
      //   $td['event']['time']['time'] = (string)$abi->ShipmentInfo->ShipmentEvent->Time;
      //   $td['event']['time']['stamp'] = strtotime($td['event']['time']['date'] . " " . $td['event']['time']['time']);
      //   //$td['event']['time']['check'] = date("c", $td['event']['time']['stamp']);
      //   $td['event']['code'] = (string)$abi->ShipmentInfo->ShipmentEvent->ServiceEvent->EventCode;
        
      //   $tmp_event_desc = (string)$abi->ShipmentInfo->ShipmentEvent->ServiceEvent->Description;
      //   $tmp_event_desc = preg_replace('/\s\s+/', ' ', $tmp_event_desc);
      //   $td['event']['desc'] = $tmp_event_desc;
        
      //   $tmp_loc_desc = (string)$abi->ShipmentInfo->ShipmentEvent->ServiceArea->Description;
      //   $tmp_loc_desc = preg_replace('/\s\s+/', ' ', $tmp_loc_desc);
      //   $td['event']['location'] = $tmp_loc_desc;

        return $td;

      //return $quote->getResponse();

    }


}
