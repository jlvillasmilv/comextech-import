<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompanyAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_addresses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id');
            $table->unsignedBigInteger('country_id')->nullable();
            $table->string('postal_code',50)->nullable();
            $table->enum('place', ['ALMACEN', 'FABRICA', 'PUERTO','OFICINA'])->default('ALMACEN');
            $table->string('address');
            $table->double('address_latitude')->nullable();
            $table->double('address_longitude')->nullable();
            $table->boolean('status')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('company_addresses');
    }
}
