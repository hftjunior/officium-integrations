<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code');
            $table->string('product');
            $table->enum('type', ['P','S']);
            $table->bigInteger('product_category_id')->unsigned();
            $table->bigInteger('product_measure_id')->unsigned();
            $table->string('erp_code');
            $table->timestamps();

            $table->foreign('product_category_id')->references('id')->on('product_categories')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('product_measure_id')->references('id')->on('product_measures')->onDelete('restrict')->onUpdate('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
