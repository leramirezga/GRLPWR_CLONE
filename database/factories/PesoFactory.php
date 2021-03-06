<?php

use Faker\Generator as Faker;

$factory->define(\App\Model\Peso::class, function (Faker $faker) {
    return [
        'peso' => $faker -> randomNumber(2),
        'usuario_id' => random_int(\DB::table('clientes')->min('usuario_id'), \DB::table('clientes')->max('usuario_id')),
        'unidad_medida' => 0,
    ];
});
