<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicationPayment extends Model
{
    use HasFactory;
    protected $table = 'application_payments';
    protected $fillable = [
        'application_id',
        'payment_method_type',
        'total',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    public static function addPayment($application_id, $data)
    {
        $data_payment = [
            ['payment_method_type' => 'PREPAGO SII', 'total' => $data['available_prepaid'] ],
            ['payment_method_type' => 'CREDITO', 'total' => $data['available_credit'] ],
        ];

        foreach ($data_payment as $key => $item) {
            ApplicationPayment::updateOrCreate(
                [
                    'application_id' => $application_id,
                    'payment_method_type' => $item['payment_method_type'],
                ],
                [ 'total' => $item['total'] ]
            );
        }

        if ($data['available_prepaid'] > 0 && auth()->user()->company->available_prepaid > 0) {
            auth()->user()->company->decrement('available_prepaid', $data['available_prepaid']);
        }

        if ($data['available_credit'] > 0 && auth()->user()->company->available_credit > 0) {
            auth()->user()->company->decrement('available_credit',  $data['available_credit']);
        }

        return true;
    }

    public static function checkPayment($application_id)
    {
        $application_payment = ApplicationPayment::where('application_id', $application_id)->get();

        if(!is_null($application_payment)){

            foreach ($application_payment as $key => $app_payment) {
                if($app_payment->payment_method_type == 'CREDITO' && $app_payment->total > 0){
                    auth()->user()->company->increment('available_prepaid', $app_payment->total);
                }

                if($app_payment->payment_method_type == 'CREDITO' && $app_payment->total > 0 ){
                    auth()->user()->company->increment('available_credit', $app_payment->total);
                }

            }

            ApplicationPayment::where('application_id', $application_id)->update(['total' => 0]);
        }

    }
}
