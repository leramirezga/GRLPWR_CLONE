<?php

use Illuminate\Database\Seeder;
use App\Model\SolicitudServicio;

class SolicitudServicioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(SolicitudServicio::class)->create();
    }
}
