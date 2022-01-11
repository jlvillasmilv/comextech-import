<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInternmentProcessesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('internment_processes', function (Blueprint $table) {
            $table->id();       
            $table->unsignedBigInteger('application_id');
            $table->unsignedBigInteger('custom_agent_id')->nullable();
            $table->unsignedBigInteger('trans_company_id')->nullable();
            $table->boolean('customs_house')->default(true);
            $table->decimal('agent_payment', 12, 2)->default(0)->nullable();
            $table->decimal('cif_amt', 12, 2)->default(0)->nullable();
            $table->boolean('iva')->default(false);
            $table->unsignedDecimal('iva_amt', 12, 2)->default(0)->nullable();
            $table->unsignedDecimal('insurance', 12, 2)->default(0)->nullable();
            $table->boolean('adv')->default(false);
            $table->decimal('adv_amt', 12, 2)->default(0)->nullable();
            $table->decimal('port_charges')->default(0)->nullable();
            $table->decimal('transport_amt', 12, 2)->default(0)->nullable();
        
            $table->timestamps();
            
            $table->foreign('application_id')->references('id')->on('applications')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('internment_processes');
    }
}
