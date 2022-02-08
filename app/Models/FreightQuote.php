<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FreightQuote extends Model
{
    protected $table = 'freight_quotes';

    protected$fillable = [
        'code',
        'freight_users_id',
        'transport_amount',
        'local_transp',
        'oth_exp',
        'insurance',
        'cif',
        'origin_address',
        'origin_postal_code',
        'origin_locality',
        'origin_ctry_code',
        'origin_latitude',
        'origin_longitude',
        'origin_port_id',
        'dest_address',
        'dest_postal_code',
        'dest_locality',
        'dest_ctry_code',
        'dest_province',
        'dest_latitude',
        'dest_longitude',
        'dest_port_id',
        'insurance',
        'local_transp',
        'shipping_date',
        'description'
    ];
}
