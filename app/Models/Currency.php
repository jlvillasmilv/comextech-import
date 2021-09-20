<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Support\HasAdvancedFilter;

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
