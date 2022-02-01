<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JumpSellerAppPayment extends Model
{
    protected $table = 'jump_seller_app_payments';
    protected $guarded = [];

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function payment()
    {
        return $this->hasMany(JumpSellerAppPayment::class, 'customer_id');
    }
}
