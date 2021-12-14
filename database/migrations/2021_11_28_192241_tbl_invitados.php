<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TblInvitados extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_invitados', function (Blueprint $table) {
            $table->increments('invitados_id');
            $table->integer('user_id')->unsigned()->nullable();
            $table->integer('status')->unsigned()->nullable();
            $table->integer('lista_codes_id')->unsigned()->nullable();
            $table->timestamps();
            
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
        Schema::dropIfExists('tbl_invitados');
    }
}
