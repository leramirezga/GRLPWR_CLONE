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
            ->get();
        $uniqueEvents = Evento::doesntHave('edited_events')
            ->where('repeatable', '=', false)
            ->where('fecha_inicio', '>=', today())
            ->where('fecha_fin', '<=', today()->addWeek())
            ->orderBy('fecha_inicio', 'asc')
            ->get();
        $repeatableEvents = Evento::doesntHave('edited_events')
            ->where('repeatable', '=', true)
            ->join('event_hours', 'eventos.id', 'event_hours.event_id')
            ->get();

        $events = $editedEvents->merge($uniqueEvents);

        $dateTime = today();
        for ($i = 0; $i < 7; $i++) {
            $dayName = $dateTime->format('l');
            $updatedCollection = $repeatableEvents->where('day', '=', $dayName)->map(function($element) use ($dateTime) {
                $element['fecha_inicio'] = $dateTime->format('d-m-Y');
                $element['fecha_fin'] = $dateTime->format('d-m-Y');
                return $element;
            });
            $events = $events->merge($updatedCollection);
            $dateTime = $dateTime->addDay();
        }

        $events->sortBy([
            ['fecha_inicio', 'asc'],
            ['hora_inicio', 'asc'],
        ]);

        $view->with('events', $events);
    }
}