<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TblEventos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_eventos', function (Blueprint $table) {
            $table->increments('eventos_id');
            $table->LongText('nombre')->nullable();
            $table->LongText('descripcion')->nullable();
            $table->date('fecha')->nullable();
            $table->time('hora_inicio')->nullable();
            $table->time('hora_fin')->nullable();
            $table->LongText('img_eventos')->nullable();
            $table->integer('status')->nullable();
            $table->integer('restaurantes_id')->unsigned()->nullable();
            $table->timestamps();

            $table->foreign('restaurantes_id')->references('restaurantes_id')->on('tbl_restaurantes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_eventos');
    }
}
