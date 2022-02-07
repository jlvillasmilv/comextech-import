<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class FreightUser extends Model
{
    protected $table = 'freight_users';

    protected $fillable = [
        'name', 'email', 'phone_number','ip','locality','ctry_code',
    ];

}
