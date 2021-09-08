<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateObjectCodeAgenciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('object_code_agencies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('object_id')->unsigned();
            $table->bigInteger('object_agency_id')->unsigned();
            $table->string('code')->nullable();
            $table->timestamps();

            $table->foreign('object_id')->references('id')->on('objects')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('object_agency_id')->references('id')->on('object_agencies')->onDelete('restrict')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('object_code_agencies');
    }
}
