<?php

use Faker\Generator as Faker;

$factory->define(App\Model\SolicitudServicio::class, function (Faker $faker) {
    return [
        'usuario_id' => random_int(\DB::table('clientes')->min('usuario_id'), \DB::table('clientes')->max('usuario_id')),
        'titulo' => $faker->sentence(1),
        'descripcion' => $faker->text(140),
        'estado' => 0,
        'oferta_aceptada' => null,
        'ciudad' => $faker -> city,
        'direccion' => $faker -> address,
        'latitud' => 4.620226800000001,
        'longitud' => -74.1139329,
        'tipo' => 0,
    ];
});
