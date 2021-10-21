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
        $from_street_lines = $data['address_origin'];
  
        $to_postal_code  = $data['origin_postal_code'];
        $to_country_code = $data['dest_ctry_code'];
        $to_city         = $data['dest_locality'];
        $to_street_lines = $data['address_destination'];
        
        
  
         // if favorite address origin is true find en storage
        if($data['fav_address_origin']){
  
          $address = SupplierAddress::where('id', $data['address_origin'])->firstOrFail();
  
          $from_postal_code = $address->postal_code;
          $from_country_code = $address->country_code;
          $from_city = $address->locality;
  
        }
        
        // if favorite address dest is true find en storage
        if($data['fav_dest_address']){
  
          $address = CompanyAddress::where('id', $data['address_destination'])->firstOrFail();
  
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
}
