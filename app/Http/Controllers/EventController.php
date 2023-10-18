<?php

namespace App\Http\Controllers;

use App\EditedEvent;
use App\EventHour;
use App\Exceptions\NoAvailableEquipmentException;
use App\Exceptions\ShoeSizeNotSupportedException;
use App\Exceptions\WeightNotSupportedException;
use App\Http\Controllers\Auth\SeguridadController;
use App\Http\Services\KangooService;
use App\Model\Evento;
use App\Repositories\ClientPlanRepository;
use App\Utils\Constantes;
use App\Utils\DaysEnum;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class EventController extends Controller
{
    protected KangooService $kangooService;

    public function __construct(KangooService $kangooService)
    {
        $this->kangooService = $kangooService;
    }

    public function create(){
        SeguridadController::verificarRol(Constantes::ROL_ADMIN);
        return view('sessions.createSession');

    }

    /**
     * Display the specified resource.
     *
     * @param  $event
     * @return View
     */
    public function show($event, $date, $hour, $isEdited)
    {
        $date = Carbon::parse($date)->format('Y-m-d');
        if($isEdited){
            $event = EditedEvent::find($event);
        } elseif ($event->repeatable){
            $event->fecha_inicio = $date;
            $event->fecha_fin = $date;
            $eventHour = EventHour::where('day', '=', Carbon::parse($date)->format('l'))->where('start_hour', $hour)->first();
            $event->start_hour = $eventHour->start_hour;
            $event->end_hour = $eventHour->end_hour;
        }

        $clientPlanRepository = new ClientPlanRepository();
        $clientPlan = $clientPlanRepository->findValidClientPlan($event);

        if ($clientPlan && $clientPlan->isNotEmpty()) {
            $clientPlan = $clientPlan->first();
            return view('sessions.event', [
                'event' => $event,
                'plan' => $clientPlan,
                'equipmentIncluded' => $clientPlan->equipment_included
            ]);
        }
        return view('sessions.event', [
            'event' => $event,
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
        $event->precio_sin_implementos = $request->priceWithoutBoots;
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

    public function nextSessions(int $branchId = null, int $classTypeId = null){

        $events = $this->loadNextSessions($branchId, $classTypeId);

        return view('proximasSesiones', compact('events'));
    }

    public function ajaxNextSessions(Request $request){

        $events = $this->loadNextSessions(null, $request->query('classTypeId'));
        if($request->query('rentEquipment') === "true"){
            $events = $this->filterEvents($events, $request->query('shoeSize'), $request->query('weight'));
        }

        return response()->json([
            'success' => true,
            'events' => $events
        ], 200);
    }

    public function filterEvents($events, int $shoeSize, int $weight){
        try {
            return $events->filter(function ($event) use ($shoeSize, $weight) {
                $startDateTime = Carbon::parse($event->fecha_fin)->format('Y-m-d') . ' ' . $event->start_hour;
                $endDateTime = Carbon::parse($event->fecha_inicio)->format('Y-m-d') . ' ' . $event->end_hour;
                    $kangooId = $this->kangooService->assignKangoo($shoeSize, $weight, $startDateTime, $endDateTime);
                    return $kangooId != null;
            });

        } catch (ShoeSizeNotSupportedException | WeightNotSupportedException | NoAvailableEquipmentException $e) {
            Session::put('msg_level', 'danger');
            Session::put('msg', $e->getMessage());
            Session::save();
            return response()->json(['error' => $e->getMessage()], $e->getCode());
        }
    }

    public function loadNextSessions(int $branchId = null, int $classTypeId = null){
        $editedEvents = EditedEvent::when($branchId, function ($query, $branchId) {
                return $query->where('branch_id', $branchId);
            })
            ->when($classTypeId, function ($query, $classTypeId) {
                return $query->where('class_type_id', $classTypeId);
            })
            ->where('fecha_inicio', '>=', today())
            ->where('fecha_fin', '<=', today()->addWeek())
            ->where('deleted', '==', '0')
            ->orderBy('fecha_inicio', 'asc')
            ->get()->map(function($element) {
                $element['id'] = $element->evento_id;
                return $element;
            });

        $uniqueEvents = Evento::doesntHave('edited_events')
            ->when($branchId, function ($query, $branchId) {
                return $query->where('branch_id', $branchId);
            })
            ->when($classTypeId, function ($query, $classTypeId) {
                return $query->where('class_type_id', $classTypeId);
            })
            ->where('repeatable', '=', false)
            ->where('fecha_inicio', '>=', today())
            ->where('fecha_fin', '<=', today()->addWeek())
            ->orderBy('fecha_inicio', 'asc')
            ->get();
        $repeatableEvents = Evento::when($branchId, function ($query, $branchId) {
                return $query->where('branch_id', $branchId);
            })
            ->when($classTypeId, function ($query, $classTypeId) {
                return $query->where('class_type_id', $classTypeId);
            })
            ->where('repeatable', '=', true)
            ->join('event_hours', 'eventos.id', 'event_hours.event_id')
            ->get();

        $events = $editedEvents->concat($uniqueEvents);

        $dateTime = today();
        for ($i = 0; $i < 7; $i++) {
            $dayName = $dateTime->format('l');
            $updatedCollection = $repeatableEvents->where('day', '=', $dayName)->map(function($element) use ($dateTime, $editedEvents) {
                if ($editedEvents->where('evento_id', '=', $element->id)
                        ->where('fecha_inicio', '=', $dateTime->format('Y-m-d'))->count() > 0) {
                    return null;
                }else{
                    $element['id'] = $element->event_id;
                    $element['fecha_inicio'] = $dateTime->format('d-m-Y');
                    $element['fecha_fin'] = $dateTime->format('d-m-Y');
                    return $element;
                }
            })->filter(function($item) {
                return $item !== null;
            });

            $events = $events->concat($updatedCollection);
            $dateTime = $dateTime->addDay();
        }

        $events = $events->sortBy([
            ['fecha_inicio', 'asc'],
            ['start_hour', 'asc'],
        ]);

        return $events;
    }
}
