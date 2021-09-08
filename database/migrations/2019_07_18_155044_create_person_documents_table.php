<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePersonDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('person_documents', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('people_id')->unsigned();
            $table->bigInteger('document_type_id')->unsigned();
            $table->string('code');
            $table->string('category')->nullable();
            $table->string('agency')->nullable();
            $table->date('dtemission')->nullable();
            $table->date('dtvalidate')->nullable();
            $table->bigInteger('person_document_frequency_id')->unsigned();
            $table->timestamps();

            $table->foreign('people_id')->references('id')->on('people')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('document_type_id')->references('id')->on('person_document_types')->onDelete('restrict')->onUpdate('cascade');            
            $table->foreign('person_document_frequency_id')->references('id')->on('person_document_frequencies')->onDelete('restrict')->onUpdate('cascade');            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('person_documents');
    }
}
