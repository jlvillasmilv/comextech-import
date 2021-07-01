<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InternmentLoad extends Model
{
    use HasFactory;

    protected $table = 'internment_loads';

    protected $guarded = [];

    protected $dates = [
        'created_at',
        'updated_at',
    ];


}
