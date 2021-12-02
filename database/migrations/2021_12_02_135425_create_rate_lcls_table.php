<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRateLclsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rate_lcl', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rate_transport_id')->references('id')->on('rate_transports')->onDelete('cascade');
            $table->unsignedDecimal('MIN_0_5', $precision = 8, $scale = 2);
            $table->unsignedDecimal('0_5_TON_M3', $precision = 8, $scale = 2);
            $table->unsignedDecimal('MIN_5_10', $precision = 8, $scale = 2);
            $table->unsignedDecimal('5_10_TON_M3', $precision = 8, $scale = 2);
            $table->unsignedDecimal('MIN_10_5', $precision = 8, $scale = 2);
            $table->unsignedDecimal('10_15_TON_M3', $precision = 8, $scale = 2);
            $table->unsignedDecimal('gl', $precision = 8, $scale = 2);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rate_lcl');
    }
}
