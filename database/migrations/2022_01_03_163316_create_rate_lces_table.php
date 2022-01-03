<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRateLcesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rate_lce', function (Blueprint $table) {
            // lce = local courier expenses
            $table->id();
            $table->foreignId('user_id')->index();
            $table->foreignId('trans_company_id')->references('id')->on('trans_companies')->onDelete('cascade');
            $table->unsignedDecimal('initial', $precision = 8, $scale = 2)->comment('Initial PRODUCT value USD');
            $table->unsignedDecimal('limit', $precision = 8, $scale = 2)->comment('Limit PRODUCT value USD');
            $table->unsignedDecimal('rate', $precision = 8, $scale = 2)->comment('Rate in USD');
            $table->date('valid_to')->nullable();
            $table->boolean('tax')->default(true)->comment('apply tax');
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
        Schema::dropIfExists('rate_lce');
    }
}
