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

    public static function addPayment($application_id ,$data)
    {
        foreach ($data as $key => $item) {
            ApplicationPayment::updateOrCreate(
                [
                    'application_id' => $application_id,
                    'payment_method_type' => $item['payment_method_type'],
                ],
                [ 'total' => $item['total'] ] 
            );

        }

        return true;
       
    }
}
