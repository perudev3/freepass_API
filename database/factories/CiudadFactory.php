<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\tbl_ciudades;
use Faker\Generator as Faker;

$factory->define(tbl_ciudades::class, function (Faker $faker) {
    return [
        'ciudades_nombre'=>$faker->city,
        'pais_id'=>1
    ];
});
