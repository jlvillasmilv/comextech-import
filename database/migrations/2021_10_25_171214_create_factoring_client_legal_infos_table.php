<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFactoringClientLegalInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('factoring_client_legal_infos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('client_id');
            $table->foreignId('user_id')->index();
            $table->date('writing_date')->nullable()->comment('Fecha escritura');
            $table->string('notary', 128)->nullable()->comment('Notaria');
            $table->string('repertoire_number', 10)->nullable()->comment('Numero repertorio');
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
        Schema::dropIfExists('factoring_client_legal_infos');
    }
}
