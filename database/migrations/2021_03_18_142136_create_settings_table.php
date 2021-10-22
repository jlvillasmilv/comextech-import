<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
   
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100)->nullable();
            $table->decimal('rate', 8, 2)->nullable()->default(1.50);
            $table->decimal('mora_rate', 8, 2)->nullable()->default(3.00);
            $table->decimal('discount', 8, 2)->nullable()->default(95);
            $table->decimal('commission', 8, 2)->nullable()->default(20000);
            $table->string('api_sii', 100)->nullable()->default('https://api.libredte.cl/api/v1/sii/rcv/ventas/detalle');
            $table->text('token_sii', 100)->nullable();
            $table->unsignedBigInteger('created_users_id')->nullable();
            $table->unsignedBigInteger('modified_users_id')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('settings');
    }
}
