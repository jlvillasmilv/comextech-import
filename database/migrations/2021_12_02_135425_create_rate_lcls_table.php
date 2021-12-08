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
            $table->foreignId('user_id')->index();
            $table->string('agent_name',50)->nullable();
            $table->string('shipping_line',50)->nullable();
            $table->string('coloader',50)->nullable();
            $table->string('contract',50)->nullable();
            $table->string('from',10)->nullable();
            $table->string('to',10)->nullable();
            $table->string('via',50)->nullable();
            $table->unsignedInteger('t_time')->nullable();
            $table->string('currency',3)->nullable();
            $table->date('valid_from')->nullable();
            $table->date('valid_to')->nullable();
            $table->unsignedDecimal('MIN_0_5', $precision = 8, $scale = 2);
            $table->unsignedDecimal('w0_5_TON_M3', $precision = 8, $scale = 2);
            $table->unsignedDecimal('MIN_5_10', $precision = 8, $scale = 2);
            $table->unsignedDecimal('w5_10_TON_M3', $precision = 8, $scale = 2);
            $table->unsignedDecimal('MIN_10_5', $precision = 8, $scale = 2);
            $table->unsignedDecimal('w10_15_TON_M3', $precision = 8, $scale = 2);
            $table->unsignedDecimal('oth_exp', $precision = 9, $scale = 2)->default(0)->comment('other expenses');
            $table->boolean('status')->default(true);
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
