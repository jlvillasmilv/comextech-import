<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomAgentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('custom_agents', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('rut',12);
            $table->string('name',100);
            $table->string('contact_person')->nullable();
            $table->decimal('rate', 12, 2)->default(0)->nullable();
            $table->string('bank',100);
            $table->string('account_number',100)->nullable();
            $table->boolean('status')->default(true);
            $table->unsignedBigInteger('modified_user_id')->nullable();
            $table->timestamps();
            $table->softDeletes($column = 'deleted_at', $precision = 0);
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('custom_agents');
    }
}
