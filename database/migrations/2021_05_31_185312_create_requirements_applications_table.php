<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequirementsApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('requirements_applications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('requirement_id');
            $table->unsignedBigInteger('application_id');
            $table->string('path');
            $table->string('file_name');
            $table->string('mime_type',50);
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
        Schema::dropIfExists('requirements_applications');
    }
}
