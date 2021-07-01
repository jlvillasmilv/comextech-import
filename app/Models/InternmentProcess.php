<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InternmentProcess extends Model
{
    use HasFactory;

    protected $table = 'internment_processes';

    protected $guarded = [];

    protected $dates = [
        'created_at',
        'updated_at',
    ];
}
