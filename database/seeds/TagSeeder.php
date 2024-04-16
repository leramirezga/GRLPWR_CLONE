<?php

use App\Model\Tags;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = array(
            array('descripcion' => 'Aeróbicos'),
            array('descripcion' => 'Calistenia'),
            array('descripcion' => 'Cardio'),
            array('descripcion' => 'Funcional'),
            array('descripcion' => 'Pilates'),
            array('descripcion' => 'Rumba'),
            array('descripcion' => 'Running'),
            array('descripcion' => 'TRX'),
            array('descripcion' => 'Workout'),
            array('descripcion' => 'Yoga'),
            array('descripcion' => 'Zumba'),
        );
        Tags::insert($data);
    }
}
