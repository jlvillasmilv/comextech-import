<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFreightShipmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('freight_shipments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('freight_quotes_id');
            $table->unsignedBigInteger('type_container')->nullable();
            $table->unsignedBigInteger('category_load_id')->nullable();
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
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('freight_shipments');
    }
}
