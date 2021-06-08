<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->unsignedTinyInteger('type')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('supplier_id')->nullable();
            $table->unsignedBigInteger('application_statuses_id');
            $table->unsignedBigInteger('currency_id')->nullable();
            $table->string('description')->nullable();
            $table->date('estimated_date')->nullable();
            $table->unsignedTinyInteger('fee1')->nullable()->comment('PAGO ADELANTO %');
            $table->unsignedTinyInteger('fee2')->nullable()->comment('PAGO_ENTREGA_%');
            $table->unsignedTinyInteger('day_pay')->nullable()->comment('Dias a pagar');
            $table->decimal('amount', 12, 2)->default(0)->nullable();
            $table->decimal('charge', 12, 2)->default(0)->nullable();
            $table->decimal('commission', 12, 2)->default(0)->nullable();
            $table->decimal('interest', 12, 2)->default(0)->nullable();
            $table->unsignedBigInteger('modified_user_id')->nullable();
            $table->timestamps();
            $table->softDeletes($column = 'deleted_at', $precision = 0);

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('application_statuses_id')->references('id')->on('application_statuses')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('applications');
    }
}
