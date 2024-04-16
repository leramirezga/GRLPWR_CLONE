<?php

use App\Model\Peso;
use Illuminate\Database\Seeder;

class PesoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Peso::class)->create();
    }
}
