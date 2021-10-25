<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFactoringFeesHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('factoring_fees_histories', function (Blueprint $table) {
            $table->id();
            $table->float('rate', 8, 2)->nullable()->default(1.50);
            $table->float('mora_rate', 8, 2)->nullable()->default(3.00);
            $table->float('discount', 8, 2)->nullable()->default(95);
            $table->float('commission', 8, 2)->nullable()->default(2000);
            $table->date('fee_date')->nullable();
            $table->unsignedBigInteger('client_payer_id');
            $table->foreign('client_payer_id')->references('id')->on('factoring_clients_payers');
            $table->timestamps();
            $table->softDeletes($column = 'deleted_at', $precision = 0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('factoring_fees_histories');
    }
}
