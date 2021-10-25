<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFactoringClientsPayersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('factoring_clients_payers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->index();
            $table->unsignedBigInteger('payer_id')->nullable();
            $table->foreign('payer_id')->references('id')->on('factoring_payers');
            $table->unsignedBigInteger('settlement_status_id')->default(1)->after('payer_id');
            $table->foreign('settlement_status_id')->references('id')->on('factoring_settlement_status');
        });
    }
    
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('factoring_clients_payers');
    }
}
