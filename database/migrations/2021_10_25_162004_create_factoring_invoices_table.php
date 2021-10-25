<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFactoringInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('factoring_invoices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('factoring_application_id');
            $table->unsignedBigInteger('factoring_payer_id');
            $table->char('type_invoice_id',3)->nullable()->default('XML');
            $table->unsignedBigInteger('status_invoice_id')->default(1);
            $table->unsignedBigInteger('fees_histories_id')->nullable();
            $table->enum('status_acuse', ['OK', 'RECIBO'])->default('RECIBO');
            $table->integer('number');
            $table->decimal('total_amount', 10, 2);
            $table->decimal('price_difference', 10, 2)->nullable();
            $table->decimal('disbursement', 10, 2)->nullable();
            $table->decimal('surplus', 10, 2)->nullable();
            $table->integer('payment_real');
            $table->string('observation')->nullable();
            $table->date('issuing_date');
            $table->date('expire_date');
            $table->timestamps();
            $table->softDeletes($column = 'deleted_at', $precision = 0);
        });

        Schema::table('factoring_invoices', static function (Blueprint $table) {
            $table->foreign('factoring_application_id')->references('id')->on('factoring_applications');
            $table->foreign('factoring_payer_id')->references('id')->on('factoring_payers');
           // $table->foreign('status_invoice_id')->references('id')->on('factoring_invoice_status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('factoring_invoices');
    }
}
