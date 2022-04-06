<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('eventos', function (Blueprint $table) {
            $table->id();
            $table->LongText('nombre')->nullable();
            $table->LongText('descripcion')->nullable();
            $table->date('fecha')->nullable();
            $table->time('hora_inicio')->nullable();
            $table->time('hora_fin')->nullable();
            $table->LongText('lugar')->nullable();
            $table->string('portada_img');
            $table->boolean('status')->default(true);
            $table->string('numero_promotor')->nullable();
            $table->string('slug')->unique();
            $table->text('lat')->nullable();
            $table->text('lng')->nullable();
            $table->timestamps();
            $table->foreignId('tipo_id')->constrained();
            $table->foreignId('user_id')->constrained();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('eventos');
    }
}
