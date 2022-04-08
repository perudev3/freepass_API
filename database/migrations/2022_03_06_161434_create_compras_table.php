<?php

use App\Compra;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComprasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('compras', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('lista_id')->constrained();
            $table->string('codigo_compra_entrada');
            $table->decimal('total_compra',11,2);
            $table->boolean('status')->default(false);
            $table->boolean('pagado')->default(false);
            $table->timestamps();
        });
        Compra::create([
            'user_id' => 1,
            'lista_id' => 1,
            'codigo_compra_entrada' => '123456789',
            'total_compra' => 15.00,
            'status' => false,
            'pagado' => false,
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('compras');
    }
}
