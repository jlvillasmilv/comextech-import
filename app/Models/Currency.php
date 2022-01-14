<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Support\HasAdvancedFilter;
use Illuminate\Support\Facades\Http;

class Currency extends Model
{
    use HasFactory;
    use HasAdvancedFilter;

    public $timestamps = false;

    protected $table = 'currencies';
    protected $guarded = [];

    public $orderable = [
        'id',
        'name',
        'code',
        'symbol',
    ];

    public $filterable = [
        'id',
        'name',
        'code',
    ];

    public function convertCurrency($amount,$from_currency,$to_currency){

        if ($from_currency == $to_currency) {
            return $amount;
        }

        $apikey = env('API_KEY_CURRENCY');
  
        $from_Currency = urlencode($from_currency);
        $to_Currency = urlencode($to_currency);
        $query =  "{$from_Currency}_{$to_Currency}";
        try {
            $url = "https://api.currconv.com/api/v7/convert?q={$query}&compact=ultra&apiKey={$apikey}";

            $httpResponse = Http::withHeaders(['Accept' => 'application/json',])->get($url);

            $obj = json_decode($httpResponse->body(), true);
      
            $val = floatval($obj["$query"]);

        } catch (\Throwable $th) {
           return number_format($amount, 2, '.', '');
        }
      
        $total = $val * $amount;
        return number_format($total, 2, '.', '');
    }
}
