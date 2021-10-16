<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCountriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('countries', function (Blueprint $table) {
            $table->id();
            $table->string('code', 2);
            $table->string('name', 80);
            $table->smallinteger('numcode')->default(0);
            $table->integer('phonecode')->nullable();
            $table->char('IPF', 1)->nullable()->comment('INT. PRIORITY FREIGHT');
            $table->char('IEF', 1)->nullable()->comment('INTERNATIONAL PRIORITY');
            $table->char('IE', 1)->nullable()->comment('INTERNATIONAL ECONOMY');
            $table->char('IP', 1)->nullable()->comment('INTERNATIONAL PRIORITY');
            $table->char('E_IPF', 1)->nullable()->comment('EXPORT INT. PRIORITY FREIGHT');
            $table->char('E_IEF', 1)->nullable()->comment('EXPORT INTERNATIONAL PRIORITY');
            $table->char('E_IE', 1)->nullable()->comment('EXPORT INTERNATIONAL ECONOMY');
            $table->char('E_IP', 1)->nullable()->comment('EXPORT INTERNATIONAL PRIORITY');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('countries');
    }
}
