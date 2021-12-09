<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImgZonasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('img_zonas', function (Blueprint $table) {
            $table->increments('img_zonas_id');
            $table->LongText('url_img')->nullable();
            $table->integer('zonas_id')->unsigned()->nullable();
            $table->timestamps();

            $table->foreign('zonas_id')->references('zonas_id')->on('tbl_zonas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('img_zonas');
    }
}
