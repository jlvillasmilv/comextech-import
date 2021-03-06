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
        'exch_rate_variation',
        'api_sii',
        'token_sii',
        'terms',
        'url_video',
        'min_rate_fcl',
        'min_rate_lcl',
        'min_rate_aereo',
        'min_rate_transp',
        'doc_mgmt_fcl',
        'loan_fcl',
        'gate_in_fcl',
        'doc_mgmt_lcl',
        'doc_visa_lcl',
        'dispatch_lcl',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];

}
