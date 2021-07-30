<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplierAddress extends Model
{
    use HasFactory;

    protected $table = 'supplier_addresses';
    protected $guarded = [];

    protected $dates = [
        'created_at',
        'updated_at',
    ];
}
 