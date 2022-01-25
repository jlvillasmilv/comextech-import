<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicationSummariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('application_summaries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('application_id')->references('id')->on('applications');
            $table->foreignId('service_id')->nullable()->references('id')->on('services')->onDelete('SET NULL');
            $table->foreignId('category_service_id')->nullable()->references('id')->on('category_services')->onDelete('SET NULL');
            $table->foreignId('currency_id')->nullable()->references('id')->on('currencies')->onDelete('SET NULL');
            $table->date('fee_date')->nullable();
            $table->decimal('amount', 12, 2)->default(0)->nullable();
            $table->decimal('amount2', 12, 2)->default(0)->nullable();
            $table->unsignedBigInteger('currency2_id')->nullable();
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
        Schema::dropIfExists('application_summaries');
    }
}
