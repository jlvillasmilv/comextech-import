<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->index();
            $table->unsignedBigInteger('country_id')->nullable();
            $table->string('tax_id',100)->unique()->nullable();
            $table->string('name',100);
            $table->string('email')->nullable();
            $table->string('phone',100)->nullable();
            $table->string('contact_name',100)->nullable();
            $table->string('contact_telf',100)->nullable();
            $table->boolean('status')->default(true);
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
        Schema::dropIfExists('companies');
    }
}
