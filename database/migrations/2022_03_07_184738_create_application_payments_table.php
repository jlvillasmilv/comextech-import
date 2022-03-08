<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicationPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('application_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('application_id')->references('id')->on('applications')->onDelete('cascade');
            $table->string('payment_method_type',20)->nullable()->comment('FACTORING SII, CREDIT, JUMPSELLERAPI');
            $table->decimal('total', 12, 2)->default(0);
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
        Schema::dropIfExists('application_payments');
    }
}
