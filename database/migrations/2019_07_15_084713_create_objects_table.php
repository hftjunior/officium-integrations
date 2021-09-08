<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateObjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('objects', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('people_id')->unsigned();
            $table->string('code');
            $table->string('oldcode')->nullable();
            $table->bigInteger('object_status_id')->unsigned();
            $table->string('serie');            
            $table->bigInteger('object_type_id')->unsigned();
            $table->bigInteger('object_manufacture_id')->unsigned();
            $table->bigInteger('object_model_id')->unsigned();
            $table->integer('year_manufacture');
            $table->integer('year_model');
            $table->decimal('capacity',11,4);
            $table->string('unit',3);
            $table->decimal('power',11,3);
            $table->decimal('cylinder',11,3);
            $table->bigInteger('object_traction_id')->nullable()->unsigned();
            $table->decimal('consumption',11,3);
            $table->bigInteger('object_fuel_id')->unsigned();
            $table->decimal('capacity_fuel',11,3);
            $table->string('unit_fuel');
            $table->char('service')->default('N');
            $table->bigInteger('responsible_id')->unsigned();            
            $table->longText('notes')->nullable();
            $table->timestamps();

            $table->foreign('people_id')->references('id')->on('people')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('object_status_id')->references('id')->on('object_statuses')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('object_type_id')->references('id')->on('object_types')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('object_manufacture_id')->references('id')->on('object_manufactures')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('object_model_id')->references('id')->on('object_models')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('object_fuel_id')->references('id')->on('object_fuels')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('responsible_id')->references('id')->on('people')->onDelete('restrict')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('objects');
    }
}
