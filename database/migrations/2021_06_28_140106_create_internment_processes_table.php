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
            $table->string('agent_name',150)->nullable();
            $table->boolean('customs_house')->default(true);
            $table->decimal('agent_payment', 12, 2)->default(0)->nullable();
            $table->enum('certificate', ['Origen', 'Fitosanitario', 'Form F'])->nullable();
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
        Schema::dropIfExists('internment_processes');
    }
}
