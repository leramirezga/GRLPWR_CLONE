<?php

namespace App\Http\Controllers;

use App\EditedEvent;
use App\EventHour;
use App\Http\Controllers\Auth\SeguridadController;
use App\Model\ClientPlan;
use App\Model\Evento;
use App\Model\SesionEvento;
use App\Model\TutorialRealizado;
use App\Utils\Constantes;
use App\Utils\DaysEnum;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Validator;

class EventController extends Controller
{
    public function create(){
        SeguridadController::verificarRol(Constantes::ROL_ADMIN);
        return view('sessions.createSession');
        //return view('cliente.crearSolicitudServicio');

    }

    /**
     * Display the specified resource.
     *
     * @param  Evento  $event
     * @return \Illuminate\Http\Response
     */
    public function show(Evento $evento, $date, $hour)
    {

        $editedEvent = EditedEvent::where('fecha_inicio', '=', $date)->first();
        if ($editedEvent){
            $evento = $editedEvent;
        }elseif ($evento->repeatable){
            $evento->fecha_inicio = $date;
            $evento->fecha_fin = $date;
            $eventHour = EventHour::where('day', '=', Carbon::parse($date)->format('l'))->where('start_hour', $hour)->first();
            $evento->start_hour = $eventHour->start_hour;
            $evento->end_hour = $eventHour->end_hour;
        }

        $clientPlan = ClientPlan::where('client_id', Auth::id())
            ->where('expiration_date', '>', now())
            ->where('remaining_classes', '>', 0)
            ->first();
        if($clientPlan){
            return view('sessions.event', [
                'event' => $evento,
                'plan' => $clientPlan,
            ]);
        }
        return view('sessions.event', [
            'event' => $evento,
        ]);
    }

    public function save(Request $request){
        $event = new Evento();
        $event->nombre = $request->name;
        $event->descripcion = $request->description;
        //TODO change image in front-end and assign it here
        $event->imagen = "request->img";
        $event->info_adicional = $request->info;
        $event->lugar = $request->place;
        $event->cupos = $request->quotas;
        $event->precio = $request->price;
        $event->precio_sin_botas = $request->priceWithoutBoots;
        $event->descuento = $request->discount;
        $event->oferta = $request->offer;
        $event->repeatable = $request->repeatable;
        if($request->repeatable){
            $event->save();
            foreach ($request->diasSemana as $day){
                $day = DaysEnum::from($day);
                $eventHour = new EventHour();
                $eventHour->event_id = $event->id;
                $eventHour->day = $day->name;
                $eventHour->start_hour =date("H:i", strtotime($request->startHour[$day->value]));
                $eventHour->end_hour = date("H:i", strtotime($request->endHour[$day->value]));
                $eventHour->save();
            }
        }else{
            $event->fecha_inicio = date('Y-m-d', strtotime(str_replace('/', '-', $request->startDate)));
            $event->fecha_fin = date('Y-m-d', strtotime(str_replace('/', '-', $request->endDate)));
            $event->start_hour =date("H:i", strtotime($request->startHour));
            $event->end_hour = date("H:i", strtotime($request->endHour));
            $event->save();
        }

    }

    /**
     * return a list of the resource for fullcalendar integration.
     *
     */
    public function fullcalendar(Request $request)
    {
        $sesionesEvento = $request->end ? DB::table('sesiones_evento')
            ->where('fecha_inicio', '>=', today())
            ->where('fecha_fin', '<=', $request->end)
            ->get() :
            DB::table('sesiones_evento')
                ->where('fecha_inicio', '>=', today())
                ->get();

        return $sesionesEvento->map(function($item) {
            $data['id'] = $item->id;
            //This can't be done with belogns to, because sesionesEvento is getting the info with DB::table
            $data['name'] = DB::table('eventos')
                ->where('id', '=', $item->evento_id)-> first()->nombre;
            $data['start'] = $item->fecha_inicio;
            $data['end'] = $item->fecha_fin;
            $data['url'] = route('evento', $item->id);
            return $data;
        });
    }

}
