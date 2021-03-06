<?php

use Faker\Generator as Faker;

$factory->define(App\Model\HorarioSolicitudServicio::class, function (Faker $faker) {
    return [
        'solicitud_servicio_id' => random_int(\DB::table('solicitudes_servicio')->min('id'), \DB::table('solicitudes_servicio')->max('id')),
        'fecha' => $faker -> date(),
        'hora_inicio' => $faker->time(),
        'hora_fin' => $faker -> time(),
        'estado' => 0,
    ];
});
