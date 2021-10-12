<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trans_companies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->index();
            $table->string('name',100);
            $table->string('description')->nullable();
            $table->string('url')->nullable();
            $table->boolean('status')->default(true);
            $table->unsignedBigInteger('modified_user_id')->nullable();
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
        Schema::dropIfExists('trans_companies');
    }
}
