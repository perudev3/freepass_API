<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImgRestaurantesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('img_restaurantes', function (Blueprint $table) {
            $table->increments('img_restaurantes_id');
            $table->LongText('url_img')->nullable();
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
        Schema::dropIfExists('img_restaurantes');
    }
}
