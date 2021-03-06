<?php

namespace App\Http\Controllers;

use App\Model\HorarioSolicitudServicio;
use App\Model\SolicitudServicio;
use App\Notifications\OfertaAceptada;
use App\Model\TransaccionesPagos;
use App\Model\TransaccionesPendientes;
use App\Utils\Constantes;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;
use Validator;
use Carbon\Carbon;

class PagosController extends Controller
{
    public function responsePago(){
        $client =new Client();
        $response = $client->get('https://secure.epayco.co/validation/v1/reference/'.request('ref_payco'));
        $data = json_decode($response->getBody()->getContents())->data;//Transforma a array porque en el response tambien se usa array y ambos usan el mismo método de procesar el pago;
        if(!$this->verificarProcesamiento($data)){//si no ha sido procesado el pago
            $this->procesarPago($data);
        }
        return redirect()->route('home', ['user' => Auth::user()]);
    }

    public function confirmationPago(){
        $data = json_decode(json_encode(request()->all()));//Transforma a array porque en el response tambien se usa array y ambos usan el mismo método de procesar el pago;
        if(!$this->verificarProcesamiento($data)){//si no ha sido procesado el pago
            $this->procesarPago($data);
        }
    }

    private function verificarProcesamiento($data){
        $transaccion = TransaccionesPagos::where('ref_payco',$data->x_ref_payco) ;
        return $transaccion->exists();
    }

    private function procesarPago($data){
        $p_cust_id_cliente = '24260';
        $p_key = 'dc11ddffb49bea81e350356bb5d980cdbc1777b0';
        $x_ref_payco = $data->x_ref_payco;
        $x_transaction_id = $data->x_transaction_id;
        $x_amount = $data->x_amount;
        $x_currency_code = $data->x_currency_code;
        $x_signature = $data->x_signature;
        $signature = hash('sha256', $p_cust_id_cliente . '^' . $p_key . '^' . $x_ref_payco . '^' . $x_transaction_id . '^' . $x_amount . '^' . $x_currency_code);
        $x_response = $data->x_response;
        $x_motivo = $data->x_response_reason_text;
        $x_id_invoice = $data->x_id_invoice;
        $x_autorizacion = $data->x_approval_code;
        var_dump($x_signature);
        var_dump($signature);
        //Validamos la firma
        if ($x_signature == $signature) {
            /*Si la firma esta bien podemos verificar los estado de la transacción*/
            $solicitud = SolicitudServicio::find($data->x_extra1);

            $x_cod_response = $data->x_cod_response;
            switch ((int)$x_cod_response) {
                case 1:
                    # code transacción aceptada
                    $solicitud->oferta_aceptada = $data->x_extra2;
                    $solicitud->estado = 1;//Contratada
                    $solicitud->save();

                    if($solicitud->tipo == Constantes::VARIAS_SESIONES){
                        $programacion = $solicitud->programacion;
                        $dia = $programacion->fecha_inicio;
                        while($dia <= $programacion->fecha_finalizacion){
                            if($dia->dayOfWeek == Carbon::MONDAY && $programacion->lunes){
                                $this->crearHorario($solicitud, $dia, $programacion->hora_inicio_lunes, $programacion->hora_fin_lunes);
                            }
                            if($dia->dayOfWeek == Carbon::TUESDAY && $programacion->martes){
                                $this->crearHorario($solicitud, $dia, $programacion->hora_inicio_martes, $programacion->hora_fin_martes);
                            }
                            if($dia->dayOfWeek == Carbon::WEDNESDAY && $programacion->miercoles){
                                $this->crearHorario($solicitud, $dia, $programacion->hora_inicio_miercoles, $programacion->hora_fin_miercoles);
                            }
                            if($dia->dayOfWeek == Carbon::THURSDAY && $programacion->jueves){
                                $this->crearHorario($solicitud, $dia, $programacion->hora_inicio_jueves, $programacion->hora_fin_jueves);
                            }
                            if($dia->dayOfWeek == Carbon::FRIDAY && $programacion->viernes){
                                $this->crearHorario($solicitud, $dia, $programacion->hora_inicio_viernes, $programacion->hora_fin_viernes);
                            }
                            if($dia->dayOfWeek == Carbon::SATURDAY && $programacion->sabado){
                                $this->crearHorario($solicitud, $dia, $programacion->hora_inicio_sabado, $programacion->hora_fin_sabado);
                            }
                            if($dia->dayOfWeek == Carbon::SUNDAY && $programacion->domingo){
                                $this->crearHorario($solicitud, $dia, $programacion->hora_inicio_domingo, $programacion->hora_fin_domingo);
                            }
                            $dia->addDay();
                        }
                    }

                    $solicitud->ofertaAceptada->entrenador->notify(new OfertaAceptada($solicitud));

                    echo 'transaccion aceptada';
                    break;
                case 2:# code transacción rechazada //EN ESTOS CASOS NO SE DEBE HACER NADA
                case 4:# code transacción fallida
                    echo 'transaccion fallida o rechazada';
                    break;
                case 3:# code transacción pendiente //ESTO SE MANEJA EN EL GUARDAR TRANSACCIÓN
                    echo 'transaccion pendiente';
                    break;
            }
        } else {
            die("Firma no valida");
        };

        $this->guardarRespuestaTx($data);

        return response()->json([
            'success' => true,
            'message' => 'transacción procesada'
        ],200);
    }

    private function crearHorario($solicitud, $dia, $horaInicio, $horaFin){
        HorarioSolicitudServicio::create(
            [
                'solicitud_servicio_id' => $solicitud->id,
                'fecha' => $dia,
                'hora_inicio' => $horaInicio,
                'hora_fin' => $horaFin,
                'estado' => 0,
            ]
        );
    }

    private function guardarRespuestaTx($data){
        $id = TransaccionesPagos::create([
            'ref_payco' => $data->x_ref_payco,
            'codigo_respuesta' => $data->x_cod_response,
            'respuesta' => $data->x_response_reason_text,
            'data' => json_encode($data),
            'id_solicitud_servicio' => $data->x_extra1,
            'id_propuesta' => $data->x_extra2,
        ])->id;
        // Cuando esta pendiente
        if ($data->x_cod_response == 3){
            TransaccionesPendientes::create([
                'id_transaccion' => $id,
                'verificada' => false,
            ]);
        }
    }

}
