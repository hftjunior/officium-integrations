<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePersonAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('person_addresses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('person_id')->unsigned();
            $table->bigInteger('street_type_id')->nullable()->unsigned();
            $table->string('street')->nullable();
            $table->integer('number')->nullable();
            $table->string('complement')->nullable();
            $table->string('neighborhood')->nullable();
            $table->bigInteger('state_id')->nullable()->unsigned();
            $table->bigInteger('city_id')->nullable()->unsigned();
            $table->string('cep',10)->nullable();
            $table->enum('type',['C','R'])->nullable();
            $table->enum('direct',['S','N'])->nullable();
            $table->timestamps();

            $table->foreign('person_id')->references('id')->on('people')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('street_type_id')->references('id')->on('street_types')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('state_id')->references('id')->on('states')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('city_id')->references('id')->on('cities')->onDelete('restrict')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('person_addresses');
    }
}
