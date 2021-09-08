<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePersonEmailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('person_emails', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('person_id')->unsigned();
            $table->string('email')->nullable();
            $table->enum('type', ['C','P'])->nullable();
            $table->timestamps();

            $table->foreign('person_id')->references('id')->on('people')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('person_emails');
    }
}
