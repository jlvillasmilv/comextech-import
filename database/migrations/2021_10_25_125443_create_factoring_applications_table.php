<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFactoringApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('factoring_applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->index();
            $table->enum('status', ['Aprobada', 'En Proceso', 'Rechazada'])->default('En Proceso');
            $table->boolean('contract_status')->default(false);
            $table->boolean('disbursement_status')->default(false);
            $table->string('observation')->nullable();
            $table->string('description')->nullable();
            $table->unsignedBigInteger('modified_users_id')->nullable();
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
        Schema::dropIfExists('factoring_applications');
    }
}
