<?php

use App\Evento;
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
            $table->foreignId('tipo_id')->constrained();
            $table->foreignId('user_id')->references('id')->on('users');
            $table->foreignId('place_id')->constrained();
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
        });
        Evento::create([
            'tipo_id' => 1,
            'user_id' => 1,
            'place_id' => 1,
            'nombre' => 'Evento 1',
            'descripcion' => 'Descripcion del evento 1',
            'fecha' => '2026-03-06',
            'hora_inicio' => '15:10:00',
            'hora_fin' => '16:10:00',
            'lugar' => 'Lugar del evento 1',
            'portada_img' => 'portada_img_1',
            'status' => true,
            'numero_promotor' => '1',
            'slug' => 'evento_1',
            'lat' => '-12.1234',
            'lng' => '-12.1234',
        ]);

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
