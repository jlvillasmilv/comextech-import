<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserMarkUpsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_mark_ups', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->index();
            $table->unsignedsmallinteger('air')->default(40)->comment('Value %');
            $table->unsignedsmallinteger('fcl')->default(40)->comment('Value %');
            $table->unsignedsmallinteger('lcl')->default(40)->comment('Value %');
            $table->unsignedsmallinteger('transfer_abroad')->default(60)->comment('Transferencia al Extranjero USD');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_mark_ups');
    }
}