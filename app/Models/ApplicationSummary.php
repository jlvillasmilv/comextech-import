<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicationSummary extends Model
{
    use HasFactory;

    protected $table = 'application_summaries';

    public $timestamps = false;

    protected $guarded = [];

    public function application()
    {
        return $this->belongsTo(Application::class,'application_id');
    }

    public function category()
    {
        return $this->belongsTo(CategoryService::class, 'category_service_id');
    }

    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class,'currency_id')->withDefault(['code' => '', 'symbol' => '' ]);
    }

    public static function setSummary($data)
    {
        $summary = \DB::table('application_summaries as aps')
        ->join('applications', 'aps.application_id', '=', 'applications.id')
        ->join('currencies as c1', 'aps.currency_id', '=', 'c1.id')
        ->join('currencies as c2', 'aps.currency2_id', '=', 'c2.id')
        ->where([
            ["aps.application_id", base64_decode($data['application_id'])],
            ["aps.status", 1],
        ])
        ->select(
            'aps.id',
            'aps.amount',
            'c1.code as currency',
            'aps.amount2',
            'aps.currency2_id',
            'c2.code as currency2',
        )
        ->get();

        $currency = null;
        if(isset($data['currency_code']) || !is_null($data['currency_code'])){
            $currency = \DB::table('currencies')
            ->where("code", $data['currency_code'])
            ->first();
        }

        foreach ($summary as $key => $item) {

                $to_currency_code = is_null($currency) ? $item->currency2 : $currency->code;
                $currency2_id     = is_null($currency) ? $item->currency2_id : $currency->id;

                $exchange = New Currency;
                $amount = $exchange->convertCurrency($item->amount, $item->currency, $to_currency_code);

                if($to_currency_code == 'CLP')
                {
                    $rate_margin = 2;
                    if(isset($data['user_id']) && $data['user_id'] > 0 )
                    {
                       $rate = UserMarkUp::where('user_id', $data['user_id'])->first()->exch_rate_margin;
                       $rate_margin = is_null($rate) ? 2 : $rate ;
                    }

                    $amount = $amount + (($amount*$rate_margin)/100);
                }

                \DB::table('application_summaries')
                ->where('id', $item->id)
                ->update([
                    "amount2"      => $amount, 
                    "currency2_id" => $currency2_id
                ]);
  
        }

        $total = \DB::table('application_summaries')
        ->where([
            ["application_id", base64_decode($data['application_id'])],
            ["status", 1],
        ])
        ->sum('amount2');

        $tco_clp = $total;

        if($to_currency_code != 'CLP'){
            $exchange = New Currency;
            $tco_clp = $exchange->convertCurrency($total, $item->currency, 'CLP');
        }

        $total_app = Application::where('id', base64_decode($data['application_id']))
            ->update(["tco" => $total, "currency_tco" => $currency2_id, 'tco_clp' => round($tco_clp,0)]);

        return $total;
    }
}
