<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContractDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contract_documents', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('contract_employee_id')->unsigned();
            $table->bigInteger('person_document_type_id')->unsigned();
            $table->date('dtpendency');
            $table->date('dtdelivery');
            $table->timestamps();

            $table->foreign('contract_employee_id')->references('id')->on('contract_employees')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('person_document_type_id')->references('id')->on('person_document_types')->onDelete('restrict')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contract_documents');
    }
}
