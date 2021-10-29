<?php

namespace App\Models\Factoring;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use SoftDeletes;

    protected $table = 'factoring_invoices';

    protected $fillable = [
        'factoring_application_id',
        'factoring_payer_id',
        'type_invoice_id',
        'status_invoice_id',
        'status_acuse',
        'number',
        'total_amount',
        'price_difference',
        'disbursement',
        'payment_real',
        'observation',
        'issuing_date',
        'expire_date'
    ];

    public function application()
    {
        return $this->belongsTo(Application::class,'factoring_application_id');
    }

    public function payer()
    {
        return $this->belongsTo(Payer::class,'factoring_payer_id');
    }


    public function invoiceStatus()
    {
        return $this->belongsTo(InvoiceStatus::class, 'id');
    }

    public function feesHistory()
    {
        return $this->belongsTo(FeesHistory::class, 'fees_histories_id');
    }
}
