<?php

namespace App\Models\Factoring;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FeesHistory extends Model
{
    use SoftDeletes;

    protected $table = 'factoring_fees_histories';

    protected $fillable = [
        'rate',
        'mora_rate',
        'discount',
        'commission',
        'client_id',
        'fee_date',
        'client_payer_id'
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];
 
    public function ClientPayer()
    {
        return $this->belongsTo(ClientPayer::class);
    }
    
    public function Invoices()
    {
        return $this->hasMany(Invoices::class,'fees_histories_id');
    }
}
