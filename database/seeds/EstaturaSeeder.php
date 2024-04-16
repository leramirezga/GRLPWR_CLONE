<?php

use App\Model\Estatura;
use Illuminate\Database\Seeder;

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
