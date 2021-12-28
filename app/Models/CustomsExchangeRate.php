<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomsExchangeRate extends Model
{
    protected $table = 'customs_exchange_rates';

    protected $guarded = [];

    protected $dates = [
        'created_at',
        'updated_at',
    ];
}
