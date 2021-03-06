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
            $table->foreignId('company_id')->nullable()->references('id')->on('companies')->onDelete('SET NULL');
            $table->string('type_transport',15)->nullable();
            $table->unsignedBigInteger('supplier_id')->nullable();
            $table->unsignedBigInteger('application_statuses_id')->default(1);
            $table->boolean('state_process')->nullable()->default(1)->comment('true = ok  false = warning');
            $table->foreignId('currency_id')->nullable()->references('id')->on('currencies')->onDelete('SET NULL');
            $table->unsignedTinyInteger('fee1')->nullable()->comment('PAGO ADELANTO %');
            $table->unsignedTinyInteger('fee2')->nullable()->comment('PAGO ADELANTO %');
            $table->unsignedBigInteger('ecommerce_id')->nullable();
            $table->text('ecommerce_url')->nullable();
            $table->string('condition', 10)->nullable();
            $table->decimal('amount', 12, 2)->default(0)->nullable();
            $table->decimal('tco', 12, 2)->default(0)->nullable()->comment('Total Cost of Operation');
            $table->foreignId('currency_tco')->nullable()->references('id')->on('currencies')->onDelete('SET NULL');
            $table->decimal('tco_clp', 12, 2)->default(0)->nullable()->comment('Total Cost of Operation CLP currencie');
            $table->string('services_code', 50)->nullable();
            $table->string('authorization_code', 6)->nullable();
            $table->unsignedBigInteger('modified_user_id')->nullable();
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
