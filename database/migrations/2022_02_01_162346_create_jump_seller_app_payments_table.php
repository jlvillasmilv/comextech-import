<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJumpSellerAppPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jump_seller_app_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('application_id')->references('id')->on('applications')->onDelete('cascade');
            $table->unsignedBigInteger('order_id')->nullable()->comment('JumpSeller order id');
            $table->unsignedBigInteger('customer_id')->nullable()->comment('JumpSeller user id');
            $table->string('status', 20)->nullable()->comment('JumpSeller Status');
            $table->string('duplicate_url')->nullable();
            $table->string('recovery_url')->nullable();
            $table->string('checkout_url')->nullable();
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
        Schema::dropIfExists('jump_seller_app_payments');
    }
}
