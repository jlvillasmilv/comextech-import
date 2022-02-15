<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FreightQuote extends Model
{
    public static function boot()
    {
        parent::boot();

        /**
        * Write code on Method
        *
        * @return response()
        */
        static::creating(function($model){
            $number =  \DB::table('freight_quotes')->max('id')+1;
           
            $model->code = 'TI-'.str_pad($number,6,0, STR_PAD_LEFT);
        });
    }

    protected $table = 'freight_quotes';

    protected$fillable = [
        'code',
        'cargo_value',
        'freight_users_id',
        'transport_amount',
        'local_transp_amt',
        'oth_exp',
        'insurance_amt',
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
        'description',
        'type_transport'
    ];

    public function customer()
    {
        return $this->belongsTo(FreightUser::class,'freight_users_id')->withDefault(['name' => '', 'email' => '']);
    }

    public function shipment()
    {
        return $this->hasMany(FreightShipment::class,'freight_quotes_id');
    }
}
