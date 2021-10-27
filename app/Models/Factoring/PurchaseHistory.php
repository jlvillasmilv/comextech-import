<?php

namespace App\Models\Factoring;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseHistory extends Model
{
    protected $table = 'factoring_purchase_histories';
    
    protected $fillable = [
        'user_id',
        'payer_id',
        'dte',
        'tipo_transaccion',
        'folio',
        'fecha',
        'fecha_recepcion',
        'fecha_acuse',
        'exento',
        'neto',
        'iva',
        'iva_no_recuperable_monto',
        'iva_no_recuperable_codigo',
        'total',
        'monto_activo_fijo',
        'monto_iva_activo_fijo',
        'iva_uso_comun',
        'impuesto_sin_credito',
        'iva_no_retenido',
        'impuesto_puros',
        'impuesto_cigarrillos',
        'impuesto_tabaco_elaborado',

    ];

    public function client()
    {
        return $this->belongsTo(App\Models\User::class,'user_id');
    }
}
