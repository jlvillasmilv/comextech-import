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
            $table->foreign('category_service_id')->references('id')->on('category_services')->onDelete('cascade');
            $table->unsignedBigInteger('suppl_cond_sale_id');
            $table->foreign('suppl_cond_sale_id')->references('id')->on('suppl_cond_sales')->onDelete('cascade');
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
