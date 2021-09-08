<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePersonEmployeeShiftsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('person_employee_shifts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('shift');
            $table->time('input');
            $table->time('output');
            $table->time('interval');
            $table->time('weekhours');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('person_employee_shifts');
    }
}
