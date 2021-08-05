<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplierAddress extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $table = 'supplier_addresses';
    protected $fillable = [
        'supplier_id',
        'address',
        'place',
    ];

}
 