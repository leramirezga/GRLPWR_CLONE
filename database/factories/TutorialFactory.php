<?php

use Faker\Generator as Faker;

$factory->define(Model::class, function (Faker $faker) {
    return [
        'descripcion' => $faker->sentence(1),
    ];
});
