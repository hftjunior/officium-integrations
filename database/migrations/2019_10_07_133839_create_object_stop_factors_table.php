<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateObjectStopFactorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('object_stop_factors', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code')->uniqid();
            $table->string('factor');
            $table->bigInteger('type_id')->unsigned();            
            $table->timestamps();

            $table->foreign('type_id')->references('id')->on('object_stop_factor_types')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('object_stop_factors');
    }
}
