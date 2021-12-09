<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblRestaurantesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_restaurantes', function (Blueprint $table) {
            $table->increments('restaurantes_id');
            $table->LongText('nombre')->nullable();
            $table->LongText('nombre_slug')->nullable();
            $table->LongText('direccion')->nullable();
            $table->LongText('telefono')->nullable();
            $table->LongText('lat')->nullable();
            $table->LongText('lng')->nullable();
            $table->LongText('foto_perfil')->nullable();
            $table->LongText('ruc')->nullable();
            $table->integer('user_id')->unsigned()->nullable();
            $table->integer('pais_id')->unsigned()->nullable();
            $table->integer('ciudades_id')->unsigned()->nullable();
            $table->timestamps();

            $table->foreign('pais_id')->references('pais_id')->on('tbl_pais');
            $table->foreign('ciudades_id')->references('ciudades_id')->on('tbl_ciudades');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_restaurantes');
    }
}
