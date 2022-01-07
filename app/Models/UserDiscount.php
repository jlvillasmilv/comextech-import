<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserDiscount extends Model
{
 
    protected $table = 'user_discounts';
    protected $guarded = [];

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    public function users()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function transCompany()
    {
        return $this->belongsTo(TransCompany::class,'trans_company_id');
    }
}
