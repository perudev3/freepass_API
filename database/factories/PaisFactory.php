<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\tbl_pais;
use Faker\Generator as Faker;

$factory->define(tbl_pais::class, function (Faker $faker) {
    return [
        'pais_nombre'=>$faker->country,
    ];
});
