<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
   
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100)->nullable();
            $table->decimal('rate', 8, 2)->nullable()->default(1.50)->comment('Factoring ');
            $table->decimal('mora_rate', 8, 2)->nullable()->default(3.00);
            $table->decimal('discount', 8, 2)->nullable()->default(95);
            $table->decimal('commission', 8, 2)->nullable()->default(20000);
            
            $table->decimal('tax', 8, 2)->nullable()->default(19);
            $table->string('api_sii', 100)->nullable()->default('https://api.libredte.cl/api/v1/sii/rcv/ventas/detalle')->comment('Url api sii');
            $table->text('token_sii', 150)->nullable();
            $table->text('terms')->nullable()->comment('Terminos y condiciones');
            $table->string('url_video')->nullable()->comment('Video bienvenida');

            $table->decimal('min_rate_fcl', 8, 2)->nullable()->default(60);
            $table->decimal('min_rate_lcl', 8, 2)->nullable()->default(60);
            $table->decimal('min_rate_aereo', 8, 2)->nullable()->default(60);
            $table->decimal('min_rate_transp', 8, 2)->nullable()->default(60);

            $table->decimal('exch_rate_variation', 4, 2)->nullable()->default(1.5)->comment('exchange rate variation');

            $table->decimal('doc_mgmt_fcl', 6, 2)->nullable()->default(25)->comment('Gestión Documental');
            $table->decimal('loan_fcl', 6, 2)->nullable()->default(120)->comment('Comodato ( X Conteiner)');
            $table->decimal('gate_in_fcl', 6, 2)->nullable()->default(120)->comment('Gate In ( X Conteiner)');
            $table->decimal('doc_mgmt_lcl', 6, 2)->nullable()->default(195)->comment('Gestión Documental LCL');
            $table->decimal('doc_visa_lcl', 6, 2)->nullable()->default(30)->comment('Visación documental LCL');
            $table->decimal('dispatch_lcl', 6, 2)->nullable()->default(30)->comment('Despacho (por Ton&M3) LCL');
           
            $table->unsignedBigInteger('created_users_id')->nullable();
            $table->unsignedBigInteger('modified_users_id')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('settings');
    }
}
