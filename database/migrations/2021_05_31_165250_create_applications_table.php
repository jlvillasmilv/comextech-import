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
            $table->string('code', 10)->nullable()->unique()->index()->comment('codigo para consultas');
            $table->unsignedTinyInteger('type')->default(1)->nullable();
            $table->foreignId('user_id')->index();
            $table->string('type_transport',15)->nullable();
            $table->unsignedBigInteger('supplier_id')->nullable();
            $table->unsignedBigInteger('application_statuses_id')->default(1);
            $table->foreignId('currency_id')->nullable()->references('id')->on('currencies')->onDelete('SET NULL');
            $table->unsignedBigInteger('ecommerce_id')->nullable();
            $table->text('ecommerce_url')->nullable();
            $table->string('condition', 10)->nullable();
            $table->unsignedTinyInteger('fee1')->nullable()->comment('PAGO ADELANTO %');
            $table->date('fee1_date')->nullable();
            $table->unsignedTinyInteger('fee2')->nullable()->comment('PAGO_ENTREGA_%');
            $table->date('fee2_date')->nullable();
            $table->unsignedTinyInteger('fee3')->nullable()->comment('PAGO_ENTREGA_% si amerita');
            $table->date('fee3_date')->nullable();
            $table->decimal('amount', 12, 2)->default(0)->nullable();
            $table->decimal('tco', 12, 2)->default(0)->nullable()->comment('Total Cost of Operation');
            $table->foreignId('currency_tco')->nullable()->references('id')->on('currencies')->onDelete('SET NULL');
            $table->unsignedBigInteger('modified_user_id')->nullable();
            $table->string('services_code', 50)->nullable();
            $table->timestamps();
            $table->softDeletes($column = 'deleted_at', $precision = 0);

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
