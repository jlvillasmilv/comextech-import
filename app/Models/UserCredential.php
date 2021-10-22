<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserCredential extends Model
{
    protected $table = 'user_credentials';
    protected $guarded = [];

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    public function users()
    {
        return $this->belongsTo(User::class,'user_id');
    }
}
