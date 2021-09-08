<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImportInconsistenciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('import_inconsistencies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('user');
            $table->string('application');
            $table->string('spreadsheet');
            $table->longText('description')->nullable();
            $table->integer('line')->nullable();
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
        Schema::dropIfExists('import_inconsistencies');
    }
}
