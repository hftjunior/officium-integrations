<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePersonProvidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('person_providers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('people_id')->unsigned();
            $table->bigInteger('owner_id')->unsigned();
            $table->enum('status', ['A', 'I'])->default('A');
            $table->timestamps();

            $table->foreign('people_id')->references('id')->on('people')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('owner_id')->references('id')->on('people')->onDelete('restrict')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('person_providers');
    }
}
