<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentProvider extends Model
{
    use HasFactory;

    protected $table = 'payment_providers';
    protected $fillable = ['application_id',
                            'currency_id',
                            'percentage',
                            'amount',
                            'type_pay',
                            'date_pay',
                            'payment_release',
                            'transfer_abroad'
                            ];

    protected $dates = [ 'created_at', 'updated_at', 'deleted_at'];

    public function application()
    {
        return $this->belongsTo(Application::class,'application_id');
    }

}
