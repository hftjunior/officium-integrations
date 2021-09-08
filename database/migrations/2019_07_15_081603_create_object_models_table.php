<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateObjectModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('object_models', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('manufacture_id')->unsigned();
            $table->string('model');
            $table->timestamps();

            $table->foreign('manufacture_id')->references('id')->on('object_manufactures')->onDelete('restrict')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('object_models');
    }
}
