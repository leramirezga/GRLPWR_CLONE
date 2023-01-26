<?php

namespace App\Http\Controllers;

use App\Model\Cliente;
use App\Model\Kangoo;
use App\Model\SesionCliente;
use App\Utils\KangooStatesEnum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Validator;

class SesionClienteController extends Controller
{
    public function save(int $sesionEventoId, int $clienteId, $kangooId)
    {
        $sesionCliente = new SesionCliente();
        $sesionCliente->cliente_id = $clienteId;
        $sesionCliente->sesion_evento_id = $sesionEventoId;
        if($kangooId!="null"){
            $sesionCliente->kangoo_id = $kangooId;
        }
        $sesionCliente->save();
    }

    public function assignKangoos(Request $request)
    {
        $clientId = $request->get('clientId');
        $client = Cliente::find($clientId);
        switch ($client->talla_zapato){
            case 35:
            case 36:
                $tallaKangoo = ["S"];
                break;
            case 37:
                $tallaKangoo = ["S", "M"];
                break;
            case 38:
                $tallaKangoo = ["M"];
                break;
            case 39:
                $tallaKangoo = ["M", "L"];
                break;
            case 40:
            case 41:
                $tallaKangoo = ["L"];
                break;
            default:
                Session::put('msg_level', 'danger');
                Session::put('msg', __('general.not_supported_shoe_size'));
                Session::save();
                return response()->json(['error' =>  __('general.not_supported_shoe_size')], 404);
        }
        $weight = $client->peso()->peso;
        if ($weight < 55){
            $resistance = 1;
        }elseif ($weight < 65) {
            $resistance = 2;
        }elseif ($weight < 76) {
            $resistance = 3;
        } elseif ($weight < 80) {
            $resistance = 4;
        }

        $kangoos = Kangoo::where('estado', KangooStatesEnum::Available)
            ->whereIn('talla', $tallaKangoo)
            ->where('resistencia', '>=', $resistance)
            ->orderBy('resistencia', 'asc')
            ->get();

        if($kangoos->isEmpty()){
            return response()->json(['error' =>  __('general.quotas_not_available')], 404);
        }
        $kangoo = ($kangoos->random(1))[0];
        $kangoo->estado = KangooStatesEnum::Assigned;
        $kangoo->save();

        return response()->json(['success' =>  __('general.not_supported_shoe_size'), 'kangooId' => $kangoo->id], 200);
    }

    public function cancelTraining(){
        $session = SesionCliente::find(request()->entrenamientoCancelar);
        if($session->fecha_inicio > now()) {
            Session::put('msg_level', 'danger');
            Session::put('msg', __('general.message_late_cancellation'));
            Session::save();
            return back();
        }
        $session->delete();
        Session::put('msg_level', 'success');
        Session::put('msg', __('general.successfully_cancelled'));
        Session::save();
        return back();
    }
}
