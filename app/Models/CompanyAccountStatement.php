<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyAccountStatement extends Model
{

    protected $table = 'company_account_statements';
    protected $fillable = [
        'company_id',
        'reference',
        'method_type',
        'debit',
        'credit',
        'movement_date'
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'movement_date',
    ];


}
