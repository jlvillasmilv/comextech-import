<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentProvidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_providers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('application_id');
            // $table->unsignedBigInteger('currency_id')->nullable();
            $table->unsignedTinyInteger('percentage')->nullable()->comment('PAGO_%');
            $table->decimal('amount', 12, 2)->default(0)->nullable();
            $table->unsignedInteger('transfer_abroad')->default(0)->nullable();
            $table->string('type_pay')->nullable();
            $table->date('date_pay')->nullable();
            $table->string('payment_release',20)->default('Sin Restricción'); 
            $table->timestamps();

            $table->foreign('application_id')->references('id')->on('applications')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payment_providers');
    }
}
