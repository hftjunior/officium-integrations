<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateObjectNoteOperationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('object_note_operations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('object_id')->unsigned();
            $table->bigInteger('implement_id')->nullable()->unsigned();
            $table->bigInteger('operator_id')->unsigned();
            $table->bigInteger('shift_id')->unsigned();
            $table->dateTime('dtnote');
            $table->bigInteger('ped_initial');
            $table->bigInteger('ped_final');
            $table->decimal('amount', 11,3);
            $table->bigInteger('measure_id')->unsigned();
            $table->bigInteger('result_center_id')->unsigned();
            $table->bigInteger('responsible_id')->unsigned();
            $table->string('code_smart')->nullable();
            $table->longText('notes')->nullable();
            $table->timestamps();

            $table->foreign('object_id')->references('id')->on('objects')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('operator_id')->references('id')->on('person_employees')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('shift_id')->references('id')->on('person_employee_shifts')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('measure_id')->references('id')->on('object_note_measures')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('result_center_id')->references('id')->on('result_centers')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('responsible_id')->references('id')->on('person_employees')->onDelete('restrict')->onUpdate('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('object_note_operations');
    }
}
