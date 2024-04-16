<?php

use App\Model\SolicitudServicio;
use Illuminate\Database\Seeder;

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
