<?php

use Faker\Generator as Faker;

$factory->define(App\Model\Review::class, function (Faker $faker) {
    return [
        'usuario_id' => random_int(\DB::table('usuarios')->min('id'), \DB::table('usuarios')->max('id')),
        'rating' => random_int(0, 5),
        'review' => $faker->text(140),
        'reviewer_id' => random_int(\DB::table('usuarios')->min('id'), \DB::table('usuarios')->max('id')),
    ];
});
