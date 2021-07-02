<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWarehousesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('warehouses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('slug')->unique();
            $table->string('name',100);
            $table->string('postal_code',10)->nullable();
            $table->text('address')->nullable();
            $table->string('phone_number',50)->nullable();
            $table->boolean('status')->default(true);
            $table->unsignedBigInteger('modified_user_id')->nullable();
            $table->timestamps();

            $table->softDeletes($column = 'deleted_at', $precision = 0);
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('warehouses');
    }
}
