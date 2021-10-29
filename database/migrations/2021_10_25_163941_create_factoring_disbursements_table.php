<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFactoringDisbursementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('factoring_disbursements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('factoring_application_id')->nullable()
            ->references('id')->on('factoring_applications');
            $table->enum('status', ['DESEMBOLSADO', 'GIRO PENDIENTE', 'EN MORA','PAGADO','RECHAZADO','PENDIENTE'])->default('PENDIENTE');
            $table->boolean('status_view')->default(false);
            $table->boolean('assign_invoices_sii')->default(false);
            $table->boolean('tax_debt')->default(false);
            $table->boolean('assignment_annex')->default(false);
            $table->decimal('total_amount', 10, 2)->nullable();
            $table->unsignedBigInteger('bank_accounts_id')->nullable();

            $table->foreign('bank_accounts_id')->references('id')->on('bank_accounts');

            $table->date('date_payment')->nullable()->comment('Fecha de pago');            
            $table->date('writing_date')->nullable()->comment('Fecha escritura');
            $table->string('notary', 128)->nullable()->comment('Notaria');
            $table->string('repertoire_number', 10)->nullable()->comment('Numero repertorio');
            $table->unsignedBigInteger('created_users_id')->nullable();
            $table->unsignedBigInteger('modified_users_id')->nullable();
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
        Schema::dropIfExists('factoring_disbursements');
    }
}
