<?php

namespace App\Console\Commands;

use App\Model\SolicitudServicio;
use App\Model\TransaccionesPagos;
use App\Model\TransaccionesPendientes;
use App\Notifications\OfertaAceptada;
use App\User;
use GuzzleHttp\Client;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;

class ValidarTransaccionesPendientes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'validator:transaccionesPendientes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Este comando valida las transacciones que retornaron pendiente en ePayco';

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
     * @return mixed
     */
    public function handle()
    {
        $transaccionesPendientes = TransaccionesPendientes::where('verificada', false)->get();
        if (!$transaccionesPendientes->isEmpty()){
            $client = new Client(); // http client
            foreach ($transaccionesPendientes as $transaccion){
                $url = 'https://secure.epayco.co/validation/v1/reference/'.$transaccion->transaccion->ref_payco;
                $request = $client->get($url);
                $response = (array) json_decode($request->getBody(), true);
                Log::info($response);
                if ($response['success'] == 'true') {
                    TransaccionesPagos::create([
                        'ref_payco' => $transaccion->transaccion->ref_payco,
                        'codigo_respuesta' => $response['data']['x_cod_response'],
                        'respuesta' => $response['data']['x_response_reason_text'],
                        'data' => json_encode($response),
                        'id_solicitud_servicio' => $transaccion->transaccion->id_solicitud_servicio,
                        'id_propuesta' => $transaccion->transaccion->id_propuesta,
                    ]);
                    if ($response['data']['x_cod_response'] == '1') {
                        $solicitud = SolicitudServicio::find($transaccion->transaccion->id_solicitud_servicio);
                        $solicitud->oferta_aceptada = $transaccion->transaccion->id_propuesta;
                        $solicitud->estado = 1;//Contratada
                        $solicitud->save();
                        $transaccion->verificada = true;
                        $transaccion->save();
                        $users = User::whereHas('ofrecimientos', function($q) use ($solicitud){
                            $q->where('id', $solicitud->oferta_aceptada);
                        })->get();
                        Log::info("Usuarios para notificar :".$users);
                        Notification::send($users, new OfertaAceptada($solicitud));
                    }

                    $transaccion->verificada = true;
                    $transaccion->save();


                }
            }
        }
    }
}
