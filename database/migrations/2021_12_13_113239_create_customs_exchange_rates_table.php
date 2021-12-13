<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomsExchangeRatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customs_exchange_rates', function (Blueprint $table) {
            $table->id();
            $table->string('currency_code',4);
            $table->unsignedDecimal('amount', $precision = 8, $scale = 2)->nullable();
            $table->date('exchange');
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
        Schema::dropIfExists('customs_exchange_rates');
    }
}
