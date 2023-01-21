<?php

namespace App\Http\Controllers;

use App\Model\TransaccionesPagos;
use App\Model\TransaccionesPendientes;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class PagosController extends Controller
{
    public function responsePayment()
    {
        $client = new Client();
        $response = $client->get('https://secure.epayco.co/validation/v1/reference/' . request('ref_payco'));
        $data = json_decode($response->getBody()->getContents())->data;//Transforma a array porque en el response tambien se usa array y ambos usan el mismo método de procesar el pago;
        if (!$this->verificarProcesamiento($data)) {//si no ha sido procesado el pago
            $this->procesarPago($data);
        }
        return redirect()->route('home', ['user' => Auth::user()]);
    }

    private function verificarProcesamiento($data)
    {
        $transaccion = TransaccionesPagos::where('ref_payco', $data->x_ref_payco);
        return $transaccion->exists();
    }

    private function procesarPago($data)
    {
        $p_cust_id_cliente = env('EPAYCO_P_CUST_ID_CLIENTE');
        $p_key = env('EPAYCO_P_KEY');
        $x_ref_payco = $data->x_ref_payco;
        $x_transaction_id = $data->x_transaction_id;
        $x_amount = $data->x_amount;
        $x_currency_code = $data->x_currency_code;
        $x_signature = $data->x_signature;
        $signature = hash('sha256', $p_cust_id_cliente . '^' . $p_key . '^' . $x_ref_payco . '^' . $x_transaction_id . '^' . $x_amount . '^' . $x_currency_code);

        //Validamos la firma
        if ($x_signature == $signature) {
            /*Si la firma esta bien podemos verificar el estado de la transacción*/
            $x_cod_response = $data->x_cod_response;
            switch ((int)$x_cod_response) {
                case 1:
                    # code transacción aceptada
                    (new SesionClienteController())->save(sesionEventoId: $data->x_extra1, clienteId: $data->x_extra2);
                    Session::put('msg_level', 'success');
                    Session::put('msg', __('general.success_purchase'));
                    Session::save();
                    break;
                case 2:# code transacción rechazada //EN ESTOS CASOS NO SE DEBE HACER NADA
                case 4:# code transacción fallida
                    Session::put('msg_level', 'danger');
                    Session::put('msg', __('general.failed_purchase'));
                    Session::save();
                    break;
                case 3:# code transacción pendiente //ESTO SE MANEJA EN EL GUARDAR TRANSACCIÓN
                    Session::put('msg_level', 'info');
                    Session::put('msg', __('general.pending_purchase'));
                    Session::save();
                    break;
            }
        } else {
            die("Firma no valida");
        };

        $this->guardarRespuestaTx($data);

        return response()->json([
            'success' => true,
            'message' => 'transacción procesada'
        ], 200);
    }

    private function guardarRespuestaTx($data){
        $id = TransaccionesPagos::create([
            'ref_payco' => $data->x_ref_payco,
            'codigo_respuesta' => $data->x_cod_response,
            'respuesta' => $data->x_response_reason_text,
            'data' => json_encode($data),
            'sesion_evento_id' => $data->x_extra1,
            'cliente_id' => $data->x_extra2,
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
