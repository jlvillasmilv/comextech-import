<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
      $apikey = env('API_KEY_CURRENCY');

      $from_Currency = urlencode($from_currency);
      $to_Currency = urlencode($to_currency);
      $query =  "{$from_Currency}_{$to_Currency}";

      $json = file_get_contents("https://free.currconv.com/api/v7/convert?q={$query}&compact=ultra&apiKey={$apikey}");
      $obj = json_decode($json, true);

      $val = floatval($obj["$query"]);


      $total = $val * $amount;
      return number_format($total, 2, '.', '');
    }

}
