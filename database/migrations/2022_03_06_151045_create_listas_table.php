<?php

use App\Lista;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateListasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('listas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('zona_id')->constrained();
            $table->foreignId('evento_id')->constrained();
            $table->string('nombre');
            $table->string('tipo_lista');
            $table->decimal('precio', 8, 2);
            $table->integer('cantidad_pases');
            $table->integer('cantidad_disponible');
            $table->text('descripcion')->nullable();
            $table->boolean('status')->default(true);
            $table->timestamps();
        });
        Lista::create([
            'zona_id' => 1,
            'evento_id' => 1,
            'nombre' => 'Lista 1',
            'tipo_lista' => 'Lista 1',
            'precio' => 15.00,
            'cantidad_pases' => 23,
            'cantidad_disponible' =>23,
            'descripcion' => 'Lista 1',
            'status' => true,
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('listas');
    }
}
