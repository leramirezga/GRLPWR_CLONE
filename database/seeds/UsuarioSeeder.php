<?php

use Illuminate\Database\Seeder;
use App\User;

class UsuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'email' => 'soporte@fitflyr.com.co',
            'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
            'rol' => 'administrador',
            'nivel'=>'0',
            'nombre'=>'FitFlyr',
            'apellido_1'=>'FitFlyr',
            'telefono'=>'3222434296',
            'fecha_nacimiento'=>'1993-05-09 00:00:00',
            'slug' => '',
        ]);
        User::create([
            'email' => 'cliente@correo.com',
            'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
            'rol' => 'cliente',
            'nivel'=>'0',
            'nombre'=>'Camilo',
            'apellido_1'=>'Hernandez',
            'apellido_2'=>'Castillo',
            'telefono'=>'3222434296',
            'fecha_nacimiento'=>'1993-05-09 00:00:00',
            'slug' => 'camilo.hernandez',
            'remember_token' => str_random(10),
        ]);
        User::create([
            'email' => 'entrenador@correo.com',
            'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
            'rol' => 'entrenador',
            'nivel'=>'1',
            'nombre'=>'Melissa',
            'apellido_1'=>'Mogollon',
            'apellido_2'=>'Elles',
            'descripcion' => 'Soy una gran entrenadora que le gusta motivar a las personas para impulsarlos a alcanzar sus metas',
            'telefono'=>'3168710356',
            'fecha_nacimiento'=>'1992-12-12 00:00:00',
            'slug' => 'melissa.mogollon',
            'remember_token' => str_random(10),
        ]);
        factory(User::class)->create();

    }
}
