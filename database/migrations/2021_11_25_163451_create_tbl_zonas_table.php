<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblZonasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_zonas', function (Blueprint $table) {
            $table->increments('zonas_id');
            $table->LongText('nombre')->nullable();
            $table->LongText('portada')->nullable();
            $table->LongText('tipo_ambiente')->nullable();
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
        Schema::dropIfExists('tbl_zonas');
    }
}
