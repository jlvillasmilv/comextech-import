<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loads', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('application_id');
            $table->unsignedBigInteger('type_container')->nullable();
            $table->unsignedBigInteger('type_load')->nullable();
            $table->boolean('mode_calculate')->default(true);
            $table->string('cbm',20)->nullable();
            $table->string('length_unit',10)->nullable();
            $table->unsignedSmallInteger('length')->nullable(); 
            $table->unsignedSmallInteger('width')->nullable(); 
            $table->unsignedSmallInteger('height')->nullable(); 
            $table->string('weight', 12)->nullable();
            $table->string('weight_units',10)->nullable();
            $table->boolean('stackable')->default(false);
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
        Schema::dropIfExists('loads');
    }
}
