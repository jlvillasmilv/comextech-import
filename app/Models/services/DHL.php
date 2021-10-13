<?php

namespace App\Models\services;

use Illuminate\Database\Eloquent\Model;

class DHL extends Model
{
    protected $_stagingUrl = 'https://xmlpitest-ea.dhl.com/XMLShippingServlet?isUTF8Support=true';
    protected $_productionUrl = 'https://xmlpi-ea.dhl.com/XMLShippingServlet?isUTF8Support=true';

    public function quoteApi($data)
    {

        // $quote = new \jackbayliss\DHLApi\Calls\GetQuote();
        // $quote->declaredValue(10)
        // ->reference("0999999999990393939333333333")
        // ->currency("USD")
        // ->toCountryCode("CL")
        // ->toPostalCode("7550214")
        // ->setPieces([
        // array("height" => 10,"width" => 10 ,"depth" => 2,"weight" => 0.5)
        // ]);

        // $response = $quote->getResponse();

        ddd($_stagingUrl);

    }
}
