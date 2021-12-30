<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Setting extends Model
{
    public $table = 'settings';

    protected $fillable = [
        'name',
        'rate',
        'mora_rate',
        'discount',
        'commission',
        'api_sii',
        'token_sii',
        'terms',
        'url_video',
        'min_rate_fcl',
        'min_rate_lcl',
        'min_rate_aereo',
        'min_rate_transp',
        'port_charges_fcl',
        'port_charges_lcl',
        'pcharge_lcl',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];

}
