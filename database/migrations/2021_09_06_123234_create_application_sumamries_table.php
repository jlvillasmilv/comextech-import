<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicationSumamriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('application_sumamries', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('application_id');
            $table->foreignId('service_id')->references('id')->on('services')->onDelete('SET NULL');
            $table->unsignedBigInteger('category_service_id');
            $table->unsignedBigInteger('currency_id')->nullable();
            $table->string('description',35)->nullable();
            $table->date('fee_date')->nullable();
            $table->decimal('amount', 12, 2)->default(0)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('application_sumamries');
    }
}
