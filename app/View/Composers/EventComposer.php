<?php

namespace App\View\Composers;

use App\EditedEvent;
use App\Model\Evento;
use App\Model\SesionEvento;
use Carbon\Carbon;
use Illuminate\View\View;

class EventComposer
{
    /**
     * Bind data to the view.
     */
    public function compose(View $view): void
    {

        $editedEvents = EditedEvent::where('fecha_inicio', '>=', today())
            ->where('fecha_fin', '<=', today()->addWeek())
            ->orderBy('fecha_inicio', 'asc')
            ->get()->map(function($element) {
                $element['id'] = $element->evento_id;
                return $element;
            });
        $uniqueEvents = Evento::doesntHave('edited_events')
            ->where('repeatable', '=', false)
            ->where('fecha_inicio', '>=', today())
            ->where('fecha_fin', '<=', today()->addWeek())
            ->orderBy('fecha_inicio', 'asc')
            ->get();
        $repeatableEvents = Evento::where('repeatable', '=', true)
            ->join('event_hours', 'eventos.id', 'event_hours.event_id')
            ->get();

        $events = $editedEvents->concat($uniqueEvents);

        $dateTime = today();
        for ($i = 0; $i < 7; $i++) {
            $dayName = $dateTime->format('l');
            $updatedCollection = $repeatableEvents->where('day', '=', $dayName)->map(function($element) use ($dateTime, $editedEvents) {
                if ($editedEvents->where('fecha_inicio', '=', $dateTime->format('Y-m-d'))->count() > 0) {
                    return null;
                }else{
                    $element['id'] = $element->event_id;
                    $element['fecha_inicio'] = $dateTime->format('d-m-Y');
                    $element['fecha_fin'] = $dateTime->format('d-m-Y');
                    return $element;
                }
            })->filter(function($item) {
                return $item !== null;
            });;
            $events = $events->concat($updatedCollection);
            $dateTime = $dateTime->addDay();
        }

        $events->sortBy([
            ['fecha_inicio', 'asc'],
            ['hora_inicio', 'asc'],
        ]);

        $view->with('events', $events);
    }
}