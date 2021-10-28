<?php

namespace App\Models\Factoring;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DisbursementStatus extends Model
{
    public $table = 'factoring_disbursement_statuses';

    protected $fillable = [
        'name',
        'status_icon',
        'status_color',
        'status',
        'modify',
        'rank',
    ];
}
