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
        'url_video'
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];

}
