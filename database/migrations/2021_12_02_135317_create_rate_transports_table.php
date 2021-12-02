<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRateTransportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rate_transports', function (Blueprint $table) {
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
            $table->char('type',1)->default('I')->comment('Type of operation I import, E export');
            $table->boolean('status')->default(true);
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
        Schema::dropIfExists('rate_transports');
    }
}
