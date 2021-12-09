<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblCiudadesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_ciudades', function (Blueprint $table) {
            $table->increments('ciudades_id');
            $table->LongText('ciudades_nombre')->nullable();
            $table->integer('pais_id')->unsigned()->nullable();
            $table->timestamps();

            $table->foreign('pais_id')->references('pais_id')->on('tbl_pais');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_ciudades');
    }
}
