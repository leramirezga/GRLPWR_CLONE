<?php

namespace App\Console\Commands;

use App\Model\SesionCliente;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class ValidarKangoosReservados extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'validator:kangosReservados';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Este comando deja disponibles los kangoos que no confirmaron el pago de las reservas';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        SesionCliente::where('reservado_hasta', '<', Carbon::now()->subMinutes(5))->delete();
        Log::info('Corriendo el schedule de los kangoos');
    }
}
