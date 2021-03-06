<?php

use Faker\Generator as Faker;

$factory->define(App\Model\Cliente::class, function (Faker $faker) {
    $usuarioID = \DB::table('usuarios')
        ->leftJoin('clientes', 'usuarios.id', '<>', 'clientes.usuario_id')
        ->where('usuarios.rol', 'cliente')
        ->select('usuarios.id')
        ->get()
        ->first();
    return [
        'usuario_id' => $usuarioID->id,
        'peso_ideal' => $faker->numberBetween(50,80),
        'biotipo' => 'ectomorfo',
    ];
});
