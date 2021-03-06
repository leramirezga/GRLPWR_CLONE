<?php

use Faker\Generator as Faker;

$factory->define(App\Model\Ofrecimientos::class, function (Faker $faker) {
    return [
        'solicitud_servicio_id' => random_int(\DB::table('solicitudes_servicio')->min('id'), \DB::table('solicitudes_servicio')->max('id')),
        'usuario_id' => random_int(\DB::table('entrenadores')->min('usuario_id'), \DB::table('entrenadores')->max('usuario_id')),
        'precio' => $faker->numberBetween(10000, 999999),
    ];
});
