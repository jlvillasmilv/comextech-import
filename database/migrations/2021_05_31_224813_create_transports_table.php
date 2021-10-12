<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transports', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('application_id');
            $table->unsignedBigInteger('trans_company_id')->nullable();
            $table->boolean('fav_address_origin')->default(false);
            $table->string('address_origin')->nullable();
            $table->double('origin_latitude')->nullable();
            $table->double('origin_longitude')->nullable();
            $table->string('origin_postal_code', 25)->nullable();
            $table->string('origin_locality', 25)->nullable();
            $table->string('origin_ctry_code', 4)->nullable();
            $table->boolean('fav_dest_address')->default(false);
            $table->string('address_destination')->nullable();
            $table->double('dest_latitude')->nullable();
            $table->double('dest_longitude')->nullable();
            $table->string('dest_postal_code', 25)->nullable();
            $table->string('dest_locality', 25)->nullable();
            $table->string('dest_ctry_code', 4)->nullable();
            $table->boolean('insurance')->default(false);
            $table->date('estimated_date')->nullable();
            $table->string('description',150)->nullable();
            $table->timestamps();
            $table->softDeletes();

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
        Schema::dropIfExists('transports');
    }
}
