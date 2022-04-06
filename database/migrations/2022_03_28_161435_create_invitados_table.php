<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvitadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invitados', function (Blueprint $table) {
            $table->id();
            $table->foreignId('compra_id')->constrained();
            $table->string('nombre');
            $table->string('apellido');
            $table->string('dni', 8);
            $table->string('carnet_vacunacion')->nullable();
            $table->string('email')->nullable();
            $table->string('telefono')->nullable();
            $table->string('codigo_invitacion');
            $table->boolean('status')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invitados');
    }
}
