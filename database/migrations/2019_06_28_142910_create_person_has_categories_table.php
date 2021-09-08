<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePersonHasCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('person_has_categories', function (Blueprint $table) {
            $table->bigInteger('person_id')->unsigned();
            $table->bigInteger('person_category_id')->unsigned();
            $table->timestamps();

            $table->foreign('person_id')->references('id')->on('people')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('person_category_id')->references('id')->on('person_categories')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('person_has_categories');
    }
}
