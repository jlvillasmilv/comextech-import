<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RateFcl extends Model
{
    protected $table = 'rate_fcl';

    protected $fillable = [
        'user_id',
        'from',
        'to',
        'via',
        't_time',
        'currency',
        'valid_from',
        'valid_to',
        'c20',
        'c40',
        'c40HC',
        'c40NOR',
        'oth_exp',
        'status'
    ];

    protected $keyType = 'string';

    public $incrementing = false;

    public $timestamps = false;

}
