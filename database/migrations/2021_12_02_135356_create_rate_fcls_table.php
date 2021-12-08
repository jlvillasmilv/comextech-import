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
            $table->foreignId('user_id')->index();
            $table->string('from',10)->nullable();
            $table->string('to',10)->nullable();
            $table->string('via',50)->nullable();
            $table->unsignedInteger('t_time')->nullable();
            $table->string('currency',3)->nullable();
            $table->date('valid_from')->nullable();
            $table->date('valid_to')->nullable();
            $table->unsignedDecimal('c20');
            $table->unsignedDecimal('c40');
            $table->unsignedDecimal('c40HC', $precision = 9, $scale = 2);
            $table->unsignedDecimal('c40NOR', $precision = 9, $scale = 2);
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
        Schema::dropIfExists('rate_fcl');
    }
}
