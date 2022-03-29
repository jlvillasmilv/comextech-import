<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransportMode extends Model
{

    public $timestamps = false;

    protected $table = 'transport_modes';
    
    protected $fillable = [
        'name', 'description',
        'icon',
        'disabled',
        'status'
    ];
}
