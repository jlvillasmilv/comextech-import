<?php

namespace App\Models\Factoring;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Payer extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'rut', 'name', 'client_id'
    ];
    private $format_rut_attribute;

    protected $table = 'factoring_payers';

    /**
     * Get the invoice associated with the payer.
     */
    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    public function feeshistory()
    {
        return $this->hasMany(FeesHistory::class,'payer_id');
    }

    public function feehistory()
    {
        return $this->hasOne(FeesHistory::class,'payer_id')->withDefault(['rate' => '0','mora_rate' => 0,'discount' => '0' ]);
    }

    public function getFormatRutAttribute()
    {
        if(strlen($this->rut) > 6){
            $rut = explode("-", $this->rut);
            return number_format(substr($rut[0], 0, 8),0,",",".").'-'.$rut[1];
        }
        return $this->rut;
    }
    
    public function clients()
    {
        return $this->hasMany(ClientPayer::class);
    }
    public function scopeInvoicesLastThreeMonths($query)
    {  
        if(auth()->user()->hasRole('Cliente')) {
            return $query->select('factoring_payers.*','factoring_invoice_histories.*', 'factoring_clients_payers.settlement_status_id')
            ->join('factoring_clients_payers', 'factoring_payers.id', '=', 'factoring_clients_payers.payer_id')
            ->join('factoring_invoice_histories', 'factoring_clients_payers.id', '=', 'factoring_invoice_histories.client_payer_id')
            ->where('factoring_clients_payers.user_id', auth()->user()->id)
            ->where('factoring_invoice_histories.indicador_sin_costo', 2)
            ->whereIn('factoring_invoice_histories.dte', [34, 33])
            ->whereBetween('fecha', [
                Carbon::now()->subMonth(3) ,
                Carbon::now()
            ]);
        }
        return 0;
        
         
    }
}
