<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResultCentersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('result_centers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('related_id')->unsigned();
            $table->string('code')->unique();
            $table->string('result_center')->unique();
            $table->timestamps();

            $table->foreign('related_id')->references('id')->on('person_related')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('result_centers');
    }
}
