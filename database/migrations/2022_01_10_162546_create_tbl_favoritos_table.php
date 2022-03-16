<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblFavoritosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_favoritos', function (Blueprint $table) {
            $table->increments('favoritos_id');
            $table->integer('user_id')->nullable();
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
        Schema::dropIfExists('tbl_favoritos');
    }
}
