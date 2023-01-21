<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Auth\SeguridadController;
use App\Model\Cliente;
use App\Model\Entrenador;
use App\Model\Estatura;
use App\Model\Ofrecimientos;
use App\Model\Peso;
use App\Model\Review;
use App\Model\Evento;
use App\Model\SesionEvento;
use App\User;
use App\Utils\Constantes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Model\SolicitudServicio;
use Illuminate\Support\Facades\DB;
use Validator;

class SesionEventoController extends Controller
{
    public function show(SesionEvento $sesion)
    {
        return view('sesionEvento', [
            'sesionEvento' => $sesion,
        ]);
    }

    /**
     * return a list of the resource for fullcalendar integration.
     *
     */
    public function fullcalendar(Request $request)
    {
        $sesionesEvento = DB::table('sesiones_evento')
            ->where('fecha_inicio', '>=', today())
            ->where('fecha_fin', '<=', $request->end)
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
