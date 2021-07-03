<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFileStoreInternmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('file_store_internments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('file_store_id');
            $table->unsignedBigInteger('internment_id');
            $table->string('intl_treaty', 20)->nullable();

            $table->foreign('file_store_id')->references('id')->on('file_stores');
            $table->foreign('internment_id')->references('id')->on('internment_processes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('file_store_internments');
    }
}
