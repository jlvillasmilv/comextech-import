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
            $table->boolean('fav_address_origin')->default(false);
            $table->string('address_origin')->nullable();
            $table->string('origin_postal_code', 35);
            $table->boolean('fav_dest_address')->default(false);
            $table->string('address_destination')->nullable();
            $table->string('destination_postal_code', 35);
            $table->boolean('insurance')->default(false);
            $table->date('estimated_date')->nullable();
            $table->string('description')->nullable();
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
