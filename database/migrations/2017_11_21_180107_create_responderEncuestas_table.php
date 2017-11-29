<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResponderEncuestasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('responder_encuestas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('encuesta_id')->unsigned();
            $table->foreign('encuesta_id')->references('id')->on('encuestas');
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
        Schema::dropIfExists('responder_encuestas');
    }
}
