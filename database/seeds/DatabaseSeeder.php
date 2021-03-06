<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->truncateTables([
            'usuarios',
            'clientes',
            'solicitudes_servicio',
            'ofrecimientos',
            'entrenadores',
            'horarios_solicitud_servicio',
            'reviews',
            'tags',
            'tags_solicitud_servicio',
            'tutoriales',
            'pesos',
            'estaturas'
        ]);

        $this->call(UsuarioSeeder::class);
        $this->call(ClienteSeeder::class);
        $this->call(SolicitudServicioSeeder::class);
        $this->call(EntrenadorSeeder::class);
        $this->call(OfrecimientoSeeder::class);
        $this->call(HorarioSolicitudServicioSeeder::class);
        $this->call(ReviewSeeder::class);
        $this->call(TagSeeder::class);
        $this->call(TagSolicitudServicioSeeder::class);
        $this->call(TutorialSeeder::class);
        $this->call(PesoSeeder::class);
        $this->call(EstaturaSeeder::class);

    }

    public function truncateTables(array $tables): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');

        foreach ($tables as $table){
            DB::table($table)->truncate();
        }
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
