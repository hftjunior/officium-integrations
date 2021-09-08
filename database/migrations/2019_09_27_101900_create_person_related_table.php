<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePersonRelatedTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('person_related', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('people_id')->unsigned();
            $table->string('cnpj');
            $table->string('erp_code');
            $table->timestamps();

            $table->foreign('people_id')->references('id')->on('people')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('person_related');
    }
}
