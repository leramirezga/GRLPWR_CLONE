<?php

use Faker\Generator as Faker;

$factory->define(\App\User::class, function (Faker $faker) {
    return [
        'email' => $faker->unique()->safeEmail,
        'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
        'rol' => $faker->randomElement(['cliente', 'entrenador']),
        'nombre' => $faker->name,
        'apellido_1' => $faker -> lastName,
        'apellido_2' => $faker -> lastName,
        'descripcion' => $faker -> text(140),
        'telefono' => \Faker\Provider\de_CH\PhoneNumber::mobileNumber(),
        'fecha_nacimiento' => $faker -> date(),
        'nivel' => $faker -> randomDigit,
        'slug' => \App\User::all()->max('id') +1,//por defecto se coloca el id como la URL (slug) inicial
        'remember_token' => str_random(10)
    ];
});
