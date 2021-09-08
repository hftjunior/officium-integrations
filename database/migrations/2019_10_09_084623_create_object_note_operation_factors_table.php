<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateObjectNoteOperationFactorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('object_note_operation_factors', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('note_operations_id')->unsigned();
            $table->bigInteger('factor_id')->unsigned();
            $table->dateTime('initial');
            $table->dateTime('end');
            $table->time('total_time');
            $table->decimal('total_decimal');
            $table->timestamps();

            $table->foreign('note_operations_id')->references('id')->on('object_note_operations')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('factor_id')->references('id')->on('object_stop_factors')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('object_note_operation_factors');
    }
}
