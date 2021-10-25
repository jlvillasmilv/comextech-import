<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFactoringDisbursementStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('factoring_disbursement_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('name',50)->unique();
            $table->string('status_icon',50)->nullable();
            $table->string('status_color',50)->nullable();
            $table->boolean('status')->default(true);
            $table->boolean('modify')->default(true);
            $table->unsignedTinyInteger('rank')->default(true);
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
        Schema::dropIfExists('factoring_disbursement_statuses');
    }
}
