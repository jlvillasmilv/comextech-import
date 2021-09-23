<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicationDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('application_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('application_id')->references('id')->on('applications')->onDelete('cascade');
            $table->unsignedBigInteger('category_service_id');
            $table->foreignId('service_id')->references('id')->on('services')->onDelete('cascade');
            $table->decimal('amount', 12, 2)->default(0)->nullable();
            $table->unsignedBigInteger('currency_id')->nullable();
            $table->decimal('amount2', 12, 2)->default(0)->nullable();
            $table->string('currency2_id',10)->nullable();
            $table->date('estimated')->nullable();
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
        Schema::dropIfExists('application_details');
    }
}
