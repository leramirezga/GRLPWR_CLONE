<?php

use Illuminate\Database\Seeder;

class TutorialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tutoriales')->insert([
            'descripcion' => 'Tutorial de creación de solicitudes de servicio'
        ]);
    }
}
