<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFactoringConnectionLibredteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('factoring_connection_libredte', function (Blueprint $table) {
            $table->id();
            $table->unsignedSmallInteger('limit')->nullable();
            $table->unsignedSmallInteger('remaining')->nullable();
            $table->date('date_limit')->nullable();
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
        Schema::dropIfExists('factoring_connection_libredte');
    }
}
