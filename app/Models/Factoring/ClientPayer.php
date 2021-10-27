<?php

namespace App\Models\Factoring;

use Illuminate\Database\Eloquent\Model;

class ClientPayer extends Model
{
    protected $table = 'factoring_clients_payers';
    
    protected $fillable = [
        'user_id',
        'payer_id',
        'settlement_status_id'
    ];
    public function client()
    {
        return $this->belongsTo(App\Models\User::class,'user_id');
    }

    public function SettlementStatus()
    {
        return $this->belongsTo(SettlementStatus::class);
    }

    public function payer()
    {
        return $this->belongsTo(Payer::class);
    }

    public function FeesHistory()
    {
        return $this->hasMany(FeesHistory::class);
    }

    public function InvoiceHistory()
    {
        return $this->hasMany(InvoiceHistory::class);
    }
}
