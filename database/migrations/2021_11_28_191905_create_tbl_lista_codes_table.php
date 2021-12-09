<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblListaCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_lista_codes', function (Blueprint $table) {
            $table->increments('lista_codes_id');
            $table->longText('nombre')->nullable();
            $table->string('codigo_invitacion')->nullable();            
            $table->integer('listas_id')->unsigned()->nullable();
            $table->integer('restaurantes_id')->unsigned()->nullable();
            $table->timestamps();
            
            $table->foreign('listas_id')->references('listas_id')->on('tbl_listas');
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
        Schema::dropIfExists('tbl_lista_codes');
    }
}
