<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Supplier extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'suppliers';
    protected $fillable = [
        'user_id',
        'name',
        'address',
        'bank',
        'isin',
        'iban',
        'phone',
        'email'
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function supplierAddress()
    {
        return $this->hasMany(SupplierAddress::class, 'supplier_id');
    }

    /**
     * Get the favorite Port with the client.
    */
    public function ports()
    {
        return $this->belongsToMany(
            Port::class,
            'ports_suppliers',
            'supplier_id',
            'port_id',
        );
    }
}
