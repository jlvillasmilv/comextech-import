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
            $table->unsignedBigInteger('category_load_id');
            $table->unsignedBigInteger('transport_id');
            $table->unsignedBigInteger('category_container_id')->nullable(); 
            $table->string('length',20)->nullable(); 
            $table->string('width',20)->nullable(); 
            $table->string('measurement',20)->nullable();
            $table->string('weighed',20)->nullable(); 
            $table->string('cbm',20)->nullable(); 
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
        Schema::dropIfExists('loads');
    }
}
