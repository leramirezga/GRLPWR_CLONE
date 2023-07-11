<?php

namespace App\Http\Controllers;

use App\Model\ClientPlan;
use App\Model\SesionEvento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Validator;

class SesionEventoController extends Controller
{
    public function show(SesionEvento $sesion)
    {
        $clientPlan = ClientPlan::where('client_id', Auth::id())
            ->where('expiration_date', '>', now())
            ->where('remaining_classes', '>', 0)
            ->first();
        if($clientPlan){
            return view('sesionEvento', [
                'sesionEvento' => $sesion,
                'plan' => $clientPlan,
        ]);
        }
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
