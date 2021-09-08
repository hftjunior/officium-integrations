<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContractProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contract_products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('contract_id')->unsigned();
            $table->bigInteger('product_id')->unsigned();
            $table->bigInteger('contract_measure_id')->unsigned();
            $table->decimal('franchise',11,3);
            $table->decimal('franchise_value',11,3);
            $table->decimal('unitary',11,3);
            $table->string('availability'); 
            $table->timestamps();

            $table->unique(['contract_id','product_id']);
            $table->foreign('contract_id')->references('id')->on('contracts')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('contract_measure_id')->references('id')->on('contract_measures')->onDelete('restrict')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contract_products');
    }
}
