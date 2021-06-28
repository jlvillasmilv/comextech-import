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
            $table->unsignedBigInteger('application_statuses_id')->default(1);
            $table->unsignedBigInteger('currency_id')->nullable();
            $table->string('description')->nullable();
            $table->string('condition', 15)->nullable();
            $table->unsignedTinyInteger('fee1')->nullable()->comment('PAGO ADELANTO %');
            $table->date('fee1_date')->nullable();
            $table->unsignedTinyInteger('fee2')->nullable()->comment('PAGO_ENTREGA_%');
            $table->date('fee2_date')->nullable();
            $table->unsignedTinyInteger('fee3')->nullable()->comment('PAGO_ENTREGA_% si amerita');
            $table->date('fee3_date')->nullable();
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
