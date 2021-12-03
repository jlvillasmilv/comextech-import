<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRateLocalTransportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rate_local_transports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->index();
            $table->unsignedInteger('weight')->nullable()->default(0);
            $table->unsignedInteger('weight_limit')->nullable();
            $table->string('weight_units',2)->nullable()->default('KG');
            $table->unsignedDecimal('amount', $precision = 8, $scale = 2);
            $table->string('from',50);
            $table->string('to',50);
            $table->string('type',2)->nullable()->default('P');
            $table->boolean('vat')->default(true)->comment('IVA');
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
        Schema::dropIfExists('rate_local_transports');
    }
}
