<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRateAirsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rate_airs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->index();
            $table->strin('airline',10)->nullable();
            $table->strin('agent',10)->nullable();
            $table->strin('clients',10)->nullable();
            $table->strin('product',10)->nullable(); 			
            $table->string('from',10)->nullable();
            $table->string('to',10)->nullable();
            $table->string('via',50)->nullable();
            $table->unsignedInteger('t_time')->nullable();
            $table->string('currency',3)->nullable();
            $table->date('valid_from')->nullable();
            $table->date('valid_to')->nullable();
            $table->unsignedDecimal('c20');
            $table->unsignedDecimal('c40');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rate_airs');
    }
}
