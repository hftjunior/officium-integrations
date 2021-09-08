<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateObjectNoteFuelSuppliesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('object_note_fuel_supplies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->dateTime('date');
            $table->bigInteger('object_id')->unsigned();
            $table->bigInteger('related_id')->unsigned();
            $table->bigInteger('result_center_id')->unsigned();
            $table->string('local');
            $table->bigInteger('operation_id')->unsigned();
            $table->bigInteger('operator_id')->unsigned();
            $table->bigInteger('pedometer');
            $table->bigInteger('provider_id')->unsigned();
            $table->bigInteger('product_id')->unsigned();
            $table->decimal('amount', 11, 3);
            $table->decimal('val_unit', 11, 3);
            $table->bigInteger('responsible_id')->unsigned();
            $table->string('code')->nullable();
            $table->string('source')->nullable();
            $table->longText('notes')->nullable();
            $table->timestamps();

            $table->foreign('object_id')->references('id')->on('objects')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('related_id')->references('id')->on('person_related')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('result_center_id')->references('id')->on('result_centers')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('operation_id')->references('id')->on('operations')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('operator_id')->references('id')->on('person_employees')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('provider_id')->references('id')->on('person_providers')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('restrict')->onUpdate('cascade');
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
        Schema::dropIfExists('object_note_fuel_supplies');
    }
}
