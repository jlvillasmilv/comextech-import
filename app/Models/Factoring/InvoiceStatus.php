<?php

namespace App\Models\Factoring;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class InvoiceStatus extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'name', 'description', 'status'
    ];

    protected $table = 'invoice_status';

    /**
     * Get the invoice associated with the invoice status.
     */
    public function invoices()
    {
        return $this->hasMany(Invoice::class, 'status_invoice_id');
    }
}
