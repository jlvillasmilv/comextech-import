<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRateFclsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rate_fcl', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rate_transport_id')->references('id')->on('rate_transports')->onDelete('cascade');
            $table->unsignedDecimal('20', $precision = 8, $scale = 2);
            $table->unsignedDecimal('40', $precision = 8, $scale = 2);
            $table->unsignedDecimal('40HC', $precision = 8, $scale = 2);
            $table->unsignedDecimal('40NOR', $precision = 8, $scale = 2);
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
        Schema::dropIfExists('rate_fcl');
    }
}
