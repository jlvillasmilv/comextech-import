<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserMarkUp extends Model
{
    protected $table = 'user_mark_ups';

    protected $fillable = [
        'user_id',
        'air',
        'fcl',
        'lcl',
        'transfer_abroad',
        'exch_rate_margin'
    ];

    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class,'user_id')->withDefault(['name' => '']);
    }

}
