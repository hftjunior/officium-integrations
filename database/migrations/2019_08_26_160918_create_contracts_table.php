<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContractsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contracts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('person_id')->unsigned();
            $table->string('number');
            $table->bigInteger('contract_purpose_id')->unsigned();
            $table->bigInteger('contract_type_id')->unsigned();
            $table->date('dtensue');
            $table->date('dtend')->nullable();
            $table->enum('status', ['A','I']);
            $table->longText('notes')->nullable();
            $table->timestamps();

            $table->foreign('person_id')->references('id')->on('people')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('contract_purpose_id')->references('id')->on('contract_purposes')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('contract_type_id')->references('id')->on('contract_types')->onDelete('restrict')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contracts');
    }
}
