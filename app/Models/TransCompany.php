<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TransCompany extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'trans_companies';
    protected $guarded = [];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $hidden = [
        'updated_at',
        'deleted_at',
    ];
}
