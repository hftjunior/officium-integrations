<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePersonEmployeeRoleHasCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('person_employee_role_has_categories', function (Blueprint $table) {
            $table->bigInteger('role_id')->unsigned();
            $table->bigInteger('category_id')->unsigned();
            $table->timestamps();

            $table->foreign('role_id')->references('id')->on('person_employee_roles')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('category_id')->references('id')->on('person_employee_role_categories')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('person_employee_role_has_categories');
    }
}
