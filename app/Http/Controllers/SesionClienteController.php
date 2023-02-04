<?php

namespace App\Http\Controllers;

use App\Model\Cliente;
use App\Model\Review;
use App\Model\ReviewSession;
use App\Model\SesionCliente;
use App\Model\SesionEvento;
use App\Utils\KangooResistancesEnum;
use App\Utils\KangooStatesEnum;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Validator;

class SesionClienteController extends Controller
{
    public function save(int $sesionEventoId, int $clienteId, $sesionClienteId)
    {
        if($sesionClienteId != "null"){//La sesion fue creada con reserva de kangoo, así que se confirma
            $sesionCliente = SesionCliente::find($sesionClienteId);
            $sesionCliente->reservado_hasta = null;
        }else{
            $sesionCliente = new SesionCliente();
            $sesionCliente->cliente_id = $clienteId;
            $sesionCliente->sesion_evento_id = $sesionEventoId;
        }
        $sesionCliente->save();
    }

    public function checkAvailability(Request $request){
        $sesionEvento = SesionEvento::find($request->get('sesionEventoId'));
        $scheduled_clients = SesionCliente::where('sesion_evento_id', $sesionEvento->id)->count();
        if($sesionEvento->cupos <= $scheduled_clients){
            Session::put('msg_level', 'danger');
            Session::put('msg', __('general.quotas_not_available'));
            Session::save();
            return response()->json(['error' =>  __('general.quotas_not_available')], 404);
        }
        if($request->get('rentKangoos')){
            return $this->assignKangoos($sesionEvento, $request->get('clientId'));
        }
        return response()->json(['success'], 200);
    }

    public function assignKangoos(SesionEvento $sesionEvento, $clientId)
    {
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
        }else{
            Session::put('msg_level', 'danger');
            Session::put('msg', __('general.not_supported_shoe_size'));
            Session::save();
            return response()->json(['error' =>  __('general.not_supported_shoe_size')], 404);
        }

        $kangoos = DB::table('kangoos')->whereNotIn('id', function($q) use($sesionEvento){
            $q->select('kangoos.id')->from('kangoos')
            ->leftJoin('sesiones_cliente', 'kangoos.id', '=', 'sesiones_cliente.kangoo_id')
            ->join('sesiones_evento', 'sesiones_cliente.sesion_evento_id', '=', 'sesiones_evento.id')
            ->where('sesiones_evento.fecha_fin', '>', $sesionEvento->fecha_inicio)
            ->where('sesiones_evento.fecha_inicio', '<', $sesionEvento->fecha_fin);
        })->where('kangoos.estado', KangooStatesEnum::Available)
            ->whereIn('talla', $tallaKangoo)
            ->where('kangoos.resistencia', '>=', $resistance)
            ->orderBy('kangoos.resistencia', 'asc')
            ->select('kangoos.id', 'kangoos.resistencia')
            ->get();

        for ($i = $resistance; $i <= KangooResistancesEnum::getMaxResistance(); $i++) {
            $kangooId = ($kangoos->where('resistencia', $i)->whenNotEmpty(function ($kangoos) {
                return $kangoos->random(1)[0]->id;
            }));
            if(is_numeric($kangooId)){
                $sesionCliente = SesionCliente::create([
                    'cliente_id' => $clientId,
                    'kangoo_id' => $kangooId,
                    'sesion_evento_id' => $sesionEvento->id,
                    'reservado_hasta' => Carbon::now()->addMinutes(5)
                ]);
                return response()->json(['success' =>  __('general.reserved_5_minutes'), 'sesionClienteId' => $sesionCliente->id], 200);
            }
        }
        Session::put('msg_level', 'danger');
        Session::put('msg', __('general.quotas_not_available'));
        Session::save();
        return response()->json(['error' =>  __('general.quotas_not_available')], 404);
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

    public function darReview(){
        if(request()->rating != null){
            $review = Review::create([
                'rating' => request()->rating,
                'review' => request()->review,
                'reviewer_id' => Auth::id(),
            ]);
            ReviewSession::create([
               'review_id' => $review->id,
               'session_id' => request()->reviewFor
            ]);
        }
        return back();
    }
}
