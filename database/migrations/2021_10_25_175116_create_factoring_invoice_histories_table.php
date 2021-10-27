<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFactoringInvoiceHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('factoring_invoice_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('client_payer_id')->after('id');
            $table->foreign('client_payer_id')->references('id')->on('factoring_clients_payers');
            $table->decimal('credito_constructoras', $precision = 10, $scale = 2)->nullable();
            $table->decimal('deposito_envases', $precision = 10, $scale = 2)->nullable();
            $table->string('dte', 5)->nullable();
            $table->decimal('exento', $precision = 10, $scale = 2)->nullable();
            $table->string('extranjero_id', 10)->nullable();
            $table->string('extranjero_nacionalidad', 100)->nullable();
            $table->date('fecha')->nullable();
            $table->dateTime('fecha_acuse')->nullable();
            $table->dateTime('fecha_recepcion')->nullable();
            $table->dateTime('fecha_reclamo')->nullable();
            $table->string('folio', 10)->nullable();
            $table->string('impuesto_adicional', 20)->nullable();
            $table->unsignedSmallInteger('indicador_servicio')->nullable();
            $table->unsignedSmallInteger('indicador_sin_costo')->nullable();
            $table->decimal('iva', $precision = 10, $scale = 2);
            $table->decimal('iva_fuera_plazo', $precision = 10, $scale = 2)->nullable();
            $table->decimal('iva_no_retenido', $precision = 10, $scale = 2)->nullable();
            $table->decimal('iva_propio', $precision = 10, $scale = 2)->nullable();
            $table->decimal('iva_retencion_parcial', $precision = 10, $scale = 2)->nullable();
            $table->decimal('iva_retencion_total', $precision = 10, $scale = 2)->nullable();
            $table->decimal('iva_terceros', $precision = 10, $scale = 2)->nullable();
            $table->string('ley_18211', 25)->nullable();
            $table->decimal('liquidacion_comision_exento', $precision = 10, $scale = 2)->nullable();
            $table->decimal('liquidacion_comision_iva', $precision = 10, $scale = 2)->nullable();
            $table->decimal('liquidacion_comision_neto', $precision = 10, $scale = 2)->nullable();
            $table->string('liquidacion_rut', 12)->nullable();
            $table->decimal('monto_no_facturable', $precision = 10, $scale = 2)->nullable();
            $table->decimal('monto_periodo', $precision = 10, $scale = 2)->nullable();
            $table->decimal('neto', $precision = 12, $scale = 2)->nullable();
            $table->string('numero_interno', 50)->nullable();
            $table->string('pasaje_internacional', 50)->nullable();
            $table->string('pasaje_nacional', 50)->nullable();
            $table->string('referencia_folio', 50)->nullable();
            $table->string('referencia_tipo', 50)->nullable();
            $table->unsignedSmallInteger('sucursal_sii')->nullable();
            $table->string('tipo_transaccion', 50)->nullable();
            $table->decimal('total', $precision = 12, $scale = 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('factoring_invoice_histories');
    }
}
