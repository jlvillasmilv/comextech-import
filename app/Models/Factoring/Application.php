<?php

namespace App\Models\Factoring;

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    protected $table = 'factoring_applications';

    protected $fillable = ['user_id',
    'status',
    'contract_status',
    'disbursement_status',
    'observation',
    'description',
    'modified_users_id',
     ];

    protected $dates = [
    'created_at',
    'updated_at',
    ];


    public function user()
    {
        return $this->belongsTo(App\Models\User::class);
    }

}
