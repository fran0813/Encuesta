<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRespuestaCerradasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('respuesta_cerradas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('respuesta');
            $table->integer('cerrada_id')->unsigned();
            $table->foreign('cerrada_id')->references('id')->on('cerradas');
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
        Schema::dropIfExists('respuesta_cerradas');
    }
}
