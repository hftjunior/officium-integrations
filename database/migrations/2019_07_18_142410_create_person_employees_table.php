<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePersonEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('person_employees', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code');
            $table->bigInteger('people_id')->unsigned();
            $table->bigInteger('employer_id')->unsigned();
            $table->enum('gender', ['M','F']);
            $table->date('dtbirth');
            $table->string('nationaly');
            $table->bigInteger('placebirth_id')->unsigned();
            $table->bigInteger('state_id')->unsigned();
            $table->date('dtadmission');
            $table->date('dtdemission')->nullable();
            $table->bigInteger('role_id')->unsigned();
            $table->decimal('salary', 11,2);
            $table->bigInteger('payment_id')->nullable()->unsigned();
            $table->bigInteger('shift_id')->nullable()->unsigned();
            $table->enum('status', ['A','I'])->default('A');
            $table->longText('notes')->nullable();
            $table->timestamps();

            $table->foreign('people_id')->references('id')->on('people')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('employer_id')->references('id')->on('people')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('placebirth_id')->references('id')->on('cities')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('state_id')->references('id')->on('states')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('role_id')->references('id')->on('person_employee_roles')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('payment_id')->references('id')->on('person_employee_payments')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('shift_id')->references('id')->on('person_employee_shifts')->onDelete('restrict')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('person_employees');
    }
}
