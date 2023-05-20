<?php

namespace App\View\Composers;

use App\Model\SesionEvento;
use Carbon\Carbon;
use Illuminate\View\View;

class SesionEventoComposer
{
    /**
     * Bind data to the view.
     */
    public function compose(View $view): void
    {
        $events = SesionEvento::where('fecha_inicio', '>=', today())
            ->where('fecha_fin', '<=', Carbon::now()->addWeek())
            ->get();

        $view->with('events', $events);
    }
}