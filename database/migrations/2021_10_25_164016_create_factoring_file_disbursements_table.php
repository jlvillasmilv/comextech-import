<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFactoringFileDisbursementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('factoring_file_disbursements', function (Blueprint $table) {
            $table->id();
            $table->string('type', 20);
            $table->unsignedBigInteger('factoring_disbursement_id');
            $table->unsignedBigInteger('file_store_id');
            $table->foreign('factoring_disbursement_id')->references('id')->on('factoring_disbursements');
            $table->foreign('file_store_id')->references('id')->on('file_stores');
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
        Schema::dropIfExists('factoring_file_disbursements');
    }
}
