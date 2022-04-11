<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicationFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('application_files', function (Blueprint $table) {
            $table->id();
            $table->foreignId('application_id')->references('id')->on('applications')->onDelete('cascade');
            $table->foreignId('file_store_id')->references('id')->on('file_stores')->onDelete('cascade');
            $table->string('document_name', 20)->nullable();
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
        Schema::dropIfExists('application_files');
    }
}
