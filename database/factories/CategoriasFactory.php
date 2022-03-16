<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\tbl_categoria;
use Faker\Generator as Faker;

$factory->define(tbl_categoria::class, function (Faker $faker) {
    return [
        'categorias_nombre'=>$faker->word,
    ];
});
