<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TblListas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_listas', function (Blueprint $table) {
            $table->increments('listas_id');
            $table->LongText('nombre')->nullable();
            $table->longText('tipo_lista')->nullable();
            $table->integer('zonas_id')->unsigned()->nullable();
            $table->integer('eventos_id')->unsigned()->nullable();
            $table->integer('lista_codes_id')->unsigned()->nullable();
            $table->decimal('precio', 10,2)->nullable();
            $table->integer('personas_x_mesa')->nullable();
            $table->integer('cant_pases')->nullable();
            $table->longText('descripcion')->nullable();
            $table->date('fecha_inicia')->nullable();
            $table->time('hora_inicia')->nullable();
            $table->date('fecha_fin')->nullable();
            $table->time('hora_fin')->nullable();
            $table->integer('status')->nullable();
            $table->timestamps();

            $table->foreign('zonas_id')->references('zonas_id')->on('tbl_zonas');
            $table->foreign('eventos_id')->references('eventos_id')->on('tbl_eventos');
            $table->foreign('lista_codes_id')->references('lista_codes_id')->on('tbl_lista_codes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_listas');
    }
}
