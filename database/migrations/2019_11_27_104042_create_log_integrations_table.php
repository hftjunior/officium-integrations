<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLogIntegrationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('log_integrations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('user');
            $table->string('form');
            $table->string('code');
            $table->enum('status', ['F', 'S']);
            $table->longtext('message')->nullable();
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
        Schema::dropIfExists('log_integrations');
    }
}
