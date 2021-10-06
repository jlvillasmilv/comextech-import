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
            $table->unsignedBigInteger('category_service_id');
            $table->unsignedBigInteger('currency_id')->nullable();
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
        Schema::dropIfExists('application_summaries');
    }
}
