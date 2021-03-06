<?php

use Faker\Generator as Faker;

$factory->define(App\Model\Entrenador::class, function (Faker $faker) {
    $usuarioID = \DB::table('usuarios')
        ->leftJoin('entrenadores', 'usuarios.id', '<>', 'entrenadores.usuario_id')
        ->where('usuarios.rol', 'entrenador')
        ->select('usuarios.id')
        ->get()
        ->first();
    return [
        'usuario_id' => $usuarioID->id,
        'banco' => $faker -> text(140),
        'tipo_cuenta' => $faker -> boolean,
        'numero_cuenta' => $faker -> bankAccountNumber,
    ];
});
