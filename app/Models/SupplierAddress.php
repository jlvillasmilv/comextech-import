<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SupplierAddress extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'supplier_addresses';
    protected $guarded = [];

    protected $dates = [
        'created_at',
        'updated_at',
    ];
}
