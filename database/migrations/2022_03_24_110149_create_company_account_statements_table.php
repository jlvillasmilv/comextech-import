<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompanyAccountStatementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_account_statements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->nullable()->references('id')->on('companies')->onDelete('SET NULL');
            $table->string('reference',20)->nullable()->comment('Codigo de solicitudes');
            $table->string('method_type',30)->nullable()->comment('FACTORING SII, CREDIT, JUMPSELLERAPI');
            $table->decimal('debit', 12, 2)->default(0);
            $table->decimal('credit', 12, 2)->default(0);
            $table->date('movement_date')->nullable();
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
        Schema::dropIfExists('company_account_statements');
    }
}
