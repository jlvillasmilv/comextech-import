<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSupplierAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('supplier_addresses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('supplier_id')->nullable();
            $table->enum('place', ['ALMACEN', 'FABRICA', 'PUERTO'])->default('ALMACEN');
            $table->double('address_latitude')->nullable();
            $table->double('address_longitude')->nullable();
            $table->string('postal_code',25)->nullable();
            $table->string('locality', 25)->nullable();
            $table->string('country_code',4)->nullable();
            $table->string('address');

            $table->foreign('supplier_id')->references('id')->on('suppliers')->onDelete('cascade');
        });
            
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('supplier_addresses');
    }
}
