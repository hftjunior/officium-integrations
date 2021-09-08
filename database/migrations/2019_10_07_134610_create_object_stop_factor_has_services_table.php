<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateObjectStopFactorHasServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('object_stop_factor_has_services', function (Blueprint $table) {
            $table->bigInteger('factor_id')->unsigned();
            $table->bigInteger('service_id')->unsigned();
            $table->timestamps();

            $table->foreign('factor_id')->references('id')->on('object_stop_factors')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('service_id')->references('id')->on('object_stop_factor_services')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('object_stop_factor_has_services');
    }
}
