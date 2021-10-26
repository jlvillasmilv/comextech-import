<?php

namespace App\Models\Factoring;

use Illuminate\Database\Eloquent\Model;

class SettlementStatus extends Model
{
    protected $table = 'factoring_settlement_status';

    protected $fillable = [
        'description', 'value', 'icon', 'color','created_at'
    ];
}
