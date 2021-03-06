<?php

use Illuminate\Database\Seeder;
use App\Model\Estatura;

class EstaturaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Estatura::class)->create();
    }
}
