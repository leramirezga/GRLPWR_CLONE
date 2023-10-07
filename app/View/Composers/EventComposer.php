<?php

namespace App\View\Composers;

use App\Http\Controllers\EventController;
use Illuminate\View\View;

class EventComposer
{
    /**
     * Bind data to the view.
     */
    public function compose(View $view): void
    {
        $eventsController = app(EventController::class);
        $events = $eventsController->loadNextSessions();

        $view->with('events', $events);
    }
}