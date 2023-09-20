<?php

namespace App\Http\Controllers;

use App\EditedEvent;
use App\Model\Cliente;
use App\Model\ClientPlan;
use App\Model\Evento;
use App\Model\Review;
use App\Model\ReviewSession;
use App\Model\SesionCliente;
use App\Model\SesionEvento;
use App\RemainingClass;
use App\Repositories\ClientPlanRepository;
use App\Utils\KangooResistancesEnum;
use App\Utils\KangooStatesEnum;
use App\Utils\PlanTypesEnum;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Validator;

class SesionClienteController extends Controller
{
    public function save(int $eventId, int $clienteId, $sesionClienteId, $startDate, $endDate)
    {
        if($sesionClienteId != "null"){//La sesion fue creada con reserva de kangoo, así que se confirma
            $sesionCliente = SesionCliente::find($sesionClienteId);
            $sesionCliente->reservado_hasta = null;
        }else{
            $sesionCliente = new SesionCliente();
            $sesionCliente->cliente_id = $clienteId;
            $sesionCliente->evento_id = $eventId;
            $sesionCliente->fecha_inicio = $startDate;
            $sesionCliente->fecha_fin = $endDate;
        }
        $sesionCliente->save();
    }

    public function scheduleEvent(Request $request){
        $editedEvent = EditedEvent::where('evento_id', $request->get('eventId'))
            ->where('fecha_inicio', '=', $request->get('startDate'))
            ->where('start_hour', '=', $request->get('startHour'))
            ->first();
        $event = $editedEvent ?: Evento::find($request->get('eventId'));
        $startDateTime = $request->get('startDate') . ' ' . $request->get('startHour');
        $endDateTime = $request->get('endDate') . ' ' . $request->get('endHour') ;
        $scheduled_clients = SesionCliente::where('evento_id', $event->id)
            ->where('fecha_inicio', '=', $startDateTime)
            ->where('fecha_fin', '=', $endDateTime)->count();
        if($event->cupos <= $scheduled_clients){
            Session::put('msg_level', 'danger');
            Session::put('msg', __('general.quotas_not_available'));
            Session::save();
            return response()->json(['error' =>  __('general.quotas_not_available')], 404);
        }
        $clientId = $request->get('clientId');
        if(filter_var($request->get('rentEquipment'), FILTER_VALIDATE_BOOLEAN)){
            $assignResponse = $this->assignEquipment($event, $clientId, $startDateTime, $endDateTime);
            if($assignResponse instanceof JsonResponse){
                return $assignResponse;
            }
        }
        return $this->validatePlan($clientId, $assignResponse ?? null, $event, $request->get('startDate'), $request->get('endDate'));
    }

    public function assignEquipment(Evento $event, $clientId, $start_date, $end_date){
        if(strcasecmp($event->classType->type, PlanTypesEnum::Kangoo->value) == 0){
            return $this->assignKangoos($event, $clientId, $start_date, $end_date);
        }
    }

    public function assignKangoos(Evento $event, $clientId, $start_date, $end_date)
    {
        $client = Cliente::find($clientId);
        switch ($client->talla_zapato){
            case 35:
            case 36:
            case 37:
                $tallaKangoo = ["S"];
                break;
            case 38:
                $tallaKangoo = ["S", "M"];
                break;
            case 39:
                $tallaKangoo = ["M"];
                break;
            case 40:
                $tallaKangoo = ["M", "L"];
                break;
            case 41:
            case 42:
            case 43:
            case 44:
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

        $kangoos = DB::table('kangoos')->whereNotIn('id', function($q) use($event, $start_date, $end_date){
            $q->select('kangoos.id')->from('kangoos')
            ->leftJoin('sesiones_cliente', 'kangoos.id', '=', 'sesiones_cliente.kangoo_id')
            ->where('sesiones_cliente.fecha_fin', '>=', Carbon::parse($start_date)->format('Y-m-d H:i:s'))
            ->where('sesiones_cliente.fecha_inicio', '<=', Carbon::parse($end_date)->format('Y-m-d H:i:s'));
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
                $sesionCliente = new SesionCliente;
                $sesionCliente->cliente_id = $clientId;
                $sesionCliente->evento_id = $event->id;
                $sesionCliente->kangoo_id = $kangooId;
                $sesionCliente->fecha_inicio = $start_date;
                $sesionCliente->fecha_fin = $end_date;
                return $sesionCliente;
            }
        }
        Session::put('msg_level', 'danger');
        Session::put('msg', __('general.not_available_kangoos'));
        Session::save();
        return response()->json(['error' =>  __('general.not_available_kangoos')], 404);
    }

    public function validatePlan($clientId, $sesionCliente = null, $event, $start_date, $end_date)
    {
        $clientPlanRepository = new ClientPlanRepository();
        $clientPlan = $clientPlanRepository->findValidClientPlan($event);

        if ($clientPlan && $clientPlan->isNotEmpty()) {
            $clientPlan = $clientPlan->first();
            $remainingClass = RemainingClass::find($clientPlan->remaining_classes_id);
            if($remainingClass->unlimited == 0) {
                if ($remainingClass->remaining_classes == null){
                    $clientPlan->remaining_shared_classes = $clientPlan->remaining_shared_classes - 1;
                    $clientPlan->save();
                }elseif($remainingClass->remaining_classes >= 0){
                    $remainingClass->remaining_classes = $remainingClass->remaining_classes - 1;
                    $remainingClass->save();
                }
            }
            if(!isset($sesionCliente)){//The customer has his own kangoos
                $sesionCliente = new SesionCliente;
                $sesionCliente->cliente_id = $clientId;
                $sesionCliente->evento_id = $event->id;
                $sesionCliente->fecha_inicio = $start_date;
                $sesionCliente->fecha_fin = $end_date;
            }
            $sesionCliente->save();//This was created above or it was created in assign kangoos method
            Session::put('msg_level', 'success');
            Session::put('msg', __('general.success_purchase'));
            Session::save();
            return response()->json(['status' =>  'success'], 201);
        }else if(isset($sesionCliente)){
            $sesionCliente->reservado_hasta = Carbon::now()->addMinutes(5);
            $sesionCliente->save();
            Session::put('msg_level', 'success');
            Session::put('msg', __('general.reserved_5_minutes'));
            Session::save();
            return response()->json(['status' =>  'reserved', 'sesionClienteId' => $sesionCliente->id], 200);
        }
        return response()->json(['status' =>  'goToPay'], 200);
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
