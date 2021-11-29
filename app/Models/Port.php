<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Port extends Model
{
    public $timestamps = false;

    protected $table = 'ports';

    protected $guarded = [];

    public function country()
    {
        return $this->belongsTo(Country::class,'country_id');
    }

    public function users()
    {
        return $this->belongsToMany(
            User::class,
            'ports_users',
            'port_id',
            'user_id',
        );
    }

    public function suppliers()
    {
        return $this->belongsToMany(
            Supplier::class,
            'ports_users',
            'port_id',
            'supplier_id',
        );
    }
}
