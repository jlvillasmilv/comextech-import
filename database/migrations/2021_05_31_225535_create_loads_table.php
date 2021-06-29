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
            $table->unsignedBigInteger('transport_id');
            $table->string('calculate_by',10)->nullable();
            $table->string('type_container',20)->nullable();
            $table->string('type_load',20)->nullable();
            $table->string('mode_selected',20)->nullable();
            $table->boolean('mode_calculate')->default(false);
            $table->string('cbm',20)->nullable();
            $table->string('high',20)->nullable(); 
            $table->string('length_unit',10)->default(''); 
            $table->string('length',20)->nullable(); 
            $table->string('width',20)->nullable(); 
            $table->decimal('weight', 12, 2)->default(0)->nullable();
            $table->string('weight_units',10)->nullable();
            $table->boolean('stackable')->default(false);

            $table->timestamps();

            $table->foreign('transport_id')->references('id')->on('transports')->onDelete('cascade');
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
