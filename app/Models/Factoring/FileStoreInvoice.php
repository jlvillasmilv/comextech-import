<?php

namespace App\Models\Factoring;

use Illuminate\Database\Eloquent\Model;

class FileStoreInvoice extends Model
{
    protected $fillable = [
        'factoring_invoice_id', 'file_store_id'
    ];

    protected $primaryKey = null;
    public $incrementing = false;
    public $timestamps = false;
    
    protected $table = 'factoring_file_stores_invoices';
    
}
