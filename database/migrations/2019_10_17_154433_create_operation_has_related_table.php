<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOperationHasRelatedTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('operation_has_related', function (Blueprint $table) {
            $table->bigInteger('operation_id')->unsigned();
            $table->bigInteger('related_id')->unsigned();
            $table->timestamps();

            $table->foreign('operation_id')->references('id')->on('operations')->onDelete('cascade')->onUpdate('cascade');            
            $table->foreign('related_id')->references('id')->on('person_related')->onDelete('cascade')->onUpdate('cascade');            

            $table->primary(['operation_id', 'related_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('operation_has_related');
    }
}
