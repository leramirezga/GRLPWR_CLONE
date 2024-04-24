<?php

namespace App\View\Composers;

use App\Model\SesionCliente;
use Illuminate\View\View;

class LatestClassesComposer
{
    /**
     * Bind data to the view.
     */
    public function compose(View $view)
    {
        $user = $view->getData()['user'];
        $lastSessions = SesionCliente::where('cliente_id', $user->id)
            ->orderBy('fecha_inicio', 'desc')
            ->take(10)
            ->get();

        $view->with([
            'lastSessions' => $lastSessions,
        ]);
    }
}
