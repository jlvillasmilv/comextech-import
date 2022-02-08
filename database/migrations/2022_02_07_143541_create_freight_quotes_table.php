<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFreightQuotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('freight_quotes', function (Blueprint $table) {
            $table->id();
            $table->string('code', 10)->nullable()->unique()->index()->comment('codigo para consultas');

            $table->unsignedBigInteger('freight_users_id');

            $table->decimal('transport_amount', 12, 2)->default(0)->nullable();
            $table->decimal('local_transp', 12, 2)->default(0)->nullable();
            $table->decimal('oth_exp', 12, 2)->default(0)->nullable();
            $table->decimal('insurance', 12, 2)->default(0)->nullable();
            $table->decimal('cif', 12, 2)->default(0)->nullable();
            
            $table->string('origin_address')->nullable();
            $table->string('origin_postal_code', 25)->nullable();
            $table->string('origin_locality', 25)->nullable();
            $table->string('origin_ctry_code', 4)->nullable();
            $table->double('origin_latitude')->nullable();
            $table->double('origin_longitude')->nullable();
            $table->unsignedBigInteger('origin_port_id')->nullable()->comment('direccion puerto origen');

            $table->string('dest_address')->nullable();
            $table->string('dest_postal_code', 25)->nullable();
            $table->string('dest_locality', 25)->nullable();
            $table->string('dest_ctry_code', 4)->nullable();
            $table->string('dest_province', 25)->nullable();
            $table->double('dest_latitude')->nullable();
            $table->double('dest_longitude')->nullable();
            $table->unsignedBigInteger('dest_port_id')->nullable()->comment('direccion puerto destino');

            $table->boolean('insurance')->default(false);
            $table->boolean('local_transp')->default(false);
            $table->date('shipping_date')->nullable();
            $table->string('description',150)->nullable();

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
        Schema::dropIfExists('freight_quotes');
    }
}
