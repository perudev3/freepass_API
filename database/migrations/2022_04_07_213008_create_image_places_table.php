<?php

use App\ImagePlace;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImagePlacesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('image_places', function (Blueprint $table) {
            $table->id();
            $table->foreignId('place_id')->constrained();
            $table->string('image_path');
            $table->timestamps();
        });
        ImagePlace::create([
            'place_id' => 1,
            'image_path' => 'images/places/1.jpg',
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('image_places');
    }
}
