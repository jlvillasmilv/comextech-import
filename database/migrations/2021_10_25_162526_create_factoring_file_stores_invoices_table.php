<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFactoringFileStoresInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('factoring_file_stores_invoices', function (Blueprint $table) {
            $table->unsignedBigInteger('factoring_invoice_id');
            $table->unsignedBigInteger('file_store_id');
        });

        Schema::table('factoring_file_stores_invoices', static function (Blueprint $table) {
            $table->foreign('factoring_invoice_id')->references('id')->on('factoring_invoices');
            $table->foreign('file_store_id')->references('id')->on('file_stores');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('factoring_file_stores_invoices');
    }
}
