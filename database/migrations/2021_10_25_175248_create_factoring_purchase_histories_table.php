<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFactoringPurchaseHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('factoring_purchase_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->index();
            $table->unsignedBigInteger('payer_id');
            $table->foreignId('factoring_payer_id')->nullable()
            ->references('id')->on('factoring_payers')->onDelete('SET NULL');
            $table->string('dte', 5)->nullable();
            $table->string('tipo_transaccion', 25)->nullable();
            $table->string('folio', 10)->nullable();
            $table->date('fecha')->nullable();
            $table->dateTime('fecha_recepcion')->nullable();
            $table->dateTime('fecha_acuse')->nullable();
            $table->decimal('exento', 10, 2)->default(0)->nullable();
            $table->decimal('neto', 10, 2)->default(0)->nullable();
            $table->decimal('iva', 10, 2)->default(0)->nullable();
            $table->string('iva_no_recuperable_monto', 10)->nullable();
            $table->string('iva_no_recuperable_codigo', 10)->nullable();
            $table->decimal('total', 10, 2)->default(0)->nullable();
            $table->string('monto_activo_fijo', 10)->nullable();
            $table->string('monto_iva_activo_fijo', 10)->nullable();
            $table->string('iva_uso_comun', 11)->nullable();
            $table->string('impuesto_sin_credito', 11)->nullable();
            $table->decimal('iva_no_retenido', 10, 0)->default(0)->nullable();
            $table->string('impuesto_puros', 20)->nullable();
            $table->string('impuesto_cigarrillos', 20)->nullable();
            $table->string('impuesto_tabaco_elaborado', 20)->nullable();
            $table->string('impuesto_adicional', 20)->nullable();
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
        Schema::dropIfExists('factoring_purchase_histories');
    }
}
