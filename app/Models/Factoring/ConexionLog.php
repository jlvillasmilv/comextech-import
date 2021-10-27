<?php

namespace App\Models\Factoring;

use Illuminate\Database\Eloquent\Model;

class ConexionLog extends Model
{
    protected $table = 'factoring_conexion_logs';
    
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}
