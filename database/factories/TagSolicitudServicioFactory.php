<?php

use Faker\Generator as Faker;

$factory->define(App\Model\TagsSolicitudServicio::class, function (Faker $faker) {
    return [
        'tag_id' => random_int(\DB::table('tags')->min('id'), \DB::table('tags')->max('id')),
        'solicitud_servicio_id' => random_int(\DB::table('solicitudes_servicio')->min('id'), \DB::table('solicitudes_servicio')->max('id')),
    ];
});
