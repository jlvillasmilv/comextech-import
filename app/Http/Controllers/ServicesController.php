<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Currency;

class ServicesController extends Controller
{
    //
    public function index()
    {
        return view('services.index');
    }
    public function show()
    {
        return view('services.show');
    }
    public function summary()
    {
        return view('services.show_summary');
    }
    public function edit()
    {
        return view('services.edit');
    }

    public function convertCurrency($amount,$from_currency,$to_currency){

        $exchange = New Currency;
        $amount = $exchange->convertCurrency($amount, $from_currency, $to_currency);
        return $amount;

    }

    public function customsConvertCurrency($amount,$from_currency){

        $current = \DB::table('customs_exchange_rates')->where('currency_code',$from_currency)->first();
        $amount = (is_null($current) ? 0 : $current->amount) * $amount; 

        return number_format($amount, 2, '.', '');

    }

    public function convertCurrencyDate($date,$from_currency,$to_currency){
      $apikey = env('API_KEY_CURRENCY');

      $from_Currency = urlencode($from_currency);
      $to_Currency = urlencode($to_currency);
      $query =  "{$from_Currency}_{$to_Currency}";

      $json = file_get_contents("https://api.currconv.com/api/v7/convert?q={$query}&compact=ultra&date={$date}&apiKey={$apikey}");
      $obj = json_decode($json, true);

      $val = floatval($obj["$query"]);

      // $total = $val * $amount;
       return number_format($obj["$query"]["$date"], 2, '.', '');
    }

}
