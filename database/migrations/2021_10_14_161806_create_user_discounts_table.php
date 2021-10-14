<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserDiscountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_discounts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->index();
            $table->smallinteger('imp_a')->default(60);
            $table->smallinteger('imp_b')->default(60);
            $table->smallinteger('imp_c')->default(60);
            $table->smallinteger('imp_d')->default(60);
            $table->smallinteger('imp_e')->default(60);
            $table->smallinteger('imp_f')->default(60);
            $table->smallinteger('exp_a')->default(60);
            $table->smallinteger('exp_b')->default(60);
            $table->smallinteger('exp_c')->default(60);
            $table->smallinteger('exp_d')->default(60);
            $table->smallinteger('exp_e')->default(60);
            $table->smallinteger('exp_f')->default(60);
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
        Schema::dropIfExists('user_discounts');
    }
}
