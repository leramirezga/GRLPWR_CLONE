<?php

use Illuminate\Database\Seeder;
use App\Model\Cliente;

class ClienteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Cliente::class)->create();
    }
}
