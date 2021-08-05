<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoryServiceSupplCondSaleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('category_service_suppl_cond_sale', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_service_id');
            $table->foreign('category_service_id', 'category_service_id_fk_1747081')->references('id')->on('category_services')->onDelete('cascade');
            $table->unsignedBigInteger('application_cond_sale_id');
            $table->foreign('application_cond_sale_id', 'application_cond_sale_id_fk_1759054')->references('id')->on('application_cond_sales')->onDelete('cascade');
            $table->boolean('selected')->default(false);
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
        Schema::dropIfExists('category_service_suppl_cond_sale');
    }
}
