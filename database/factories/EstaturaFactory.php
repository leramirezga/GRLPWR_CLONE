<?php

use Faker\Generator as Faker;

$factory->define(\App\Model\Estatura::class, function (Faker $faker) {
    return [
        'estatura' => $faker -> randomNumber(2),
        'usuario_id' => random_int(\DB::table('clientes')->min('usuario_id'), \DB::table('clientes')->max('usuario_id')),
        'unidad_medida' => 0,
    ];
});
