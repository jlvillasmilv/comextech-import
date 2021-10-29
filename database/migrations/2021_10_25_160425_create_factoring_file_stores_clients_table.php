<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFactoringFileStoresClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('factoring_file_stores_clients', function (Blueprint $table) {
            $table->id();
            $table->string('type', 20);
            $table->foreignId('user_id')->index();
            $table->unsignedBigInteger('file_store_id');
            $table->foreign('file_store_id')->references('id')->on('file_stores');
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
        Schema::dropIfExists('factoring_file_stores_clients');
    }
}
