<?php

namespace App\Models\Factoring;

use Illuminate\Database\Eloquent\Model;

class InvoiceHistory extends Model
{
    protected $table = 'factoring_invoice_histories';
    
    protected $fillable = [
        'client_payer_id',
        'credito_constructoras',
        'deposito_envases',
        'dte',
        'exento',
        'extranjero_id',
        'extranjero_nacionalidad',
        'fecha',
        'fecha_acuse',
        'fecha_recepcion',
        'fecha_reclamo',
        'folio',
        'impuesto_adicional',
        'indicador_servicio',
        'indicador_sin_costo',
        'iva',
        'iva_fuera_plazo',
        'iva_no_retenido',
        'iva_propio',
        'iva_retencion_parcial',
        'iva_retencion_total',
        'iva_terceros',
        'ley_18211',
        'liquidacion_comision_exento',
        'liquidacion_comision_iva',
        'liquidacion_comision_neto',
        'liquidacion_rut',
        'monto_no_facturable',
        'monto_periodo',
        'neto',
        'numero_interno',
        'pasaje_internacional',
        'pasaje_nacional',
        'referencia_folio',
        'referencia_tipo',
        'sucursal_sii',
        'tipo_transaccion',
        'total',
    ];

    public function clientPayer()
    {
        return $this->belongsTo(ClientPayer::class);
    }
}
