<?php

use Illuminate\Database\Seeder;
use App\Model\Peso;

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
