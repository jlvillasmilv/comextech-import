<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInternmentProcessesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('internment_processes', function (Blueprint $table) {
            $table->id();       
            $table->unsignedBigInteger('application_id');
            $table->unsignedBigInteger('custom_agent_id')->nullable();
            $table->boolean('customs_house')->default(true);
            $table->decimal('agent_payment', 12, 2)->default(0)->nullable();
            $table->enum('certificate', ['Origen', 'Fitosanitario', 'Form F'])->nullable();
            $table->timestamps();
            
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
        Schema::dropIfExists('internment_processes');
    }
}
