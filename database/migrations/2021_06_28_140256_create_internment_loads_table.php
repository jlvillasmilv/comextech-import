<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInternmentLoadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('internment_loads', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('internment_id');
            $table->string('calculate_by',10)->nullable();
            $table->string('type_container',20)->nullable();
            $table->string('type_load',20)->nullable();
            $table->string('mode_selected',20)->nullable();
            $table->boolean('mode_calculate')->default(false);
            $table->string('cbm',20)->nullable();
            $table->string('high',20)->nullable(); 
            $table->boolean('length_unit')->default(false); 
            $table->string('length',20)->nullable(); 
            $table->string('width',20)->nullable(); 
            $table->decimal('weight', 12, 2)->default(0)->nullable();
            $table->string('weight_units',10)->nullable();
            $table->boolean('stackable')->default(false);
            $table->timestamps();

            $table->foreign('internment_id')->references('id')->on('internment_processes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('internment_loads');
    }
}
