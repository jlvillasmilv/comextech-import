<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Support\HasAdvancedFilter;

class Currency extends Model
{
    use HasFactory;
    use HasAdvancedFilter;

    protected $table = 'currencies';
    protected $guarded = [];

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    public $orderable = [
        'id',
        'name',
        'code',
        'symbol',
    ];

    public $filterable = [
        'id',
        'name',
        'code',
    ];
}
