<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Auth\SeguridadController;
use App\Model\SolicitudServicio;
use App\Model\Tags;
use App\User;
use App\Utils\Constantes;
use Illuminate\Support\Facades\Auth;

class BusquedaEntrenadorController extends Controller
{


    public function buscarEntrenador(){
        SeguridadController::verificarRol('cliente');
        $tags = Tags::all();
        $ciudades = ['Bogotá', 'Medellin'];

        $tagsCheck = null;
        $ciudadesCheck = null;
        $maximaDistancia = 25;//Carga 25 kilometros por defecto

        $entrenadores = User::where('rol', Constantes::ROL_ENTRENADOR)
                        ->whereHas('entrenador', function ($q){
                            $q->where('tarifa', '<>', '');
                        })
                        ->get();//TODO filtrar por la ciudad donde se registró el cliente y mostra checked esa ciudad
        return view('busquedaEntrenadores', compact('entrenadores', 'ciudades', 'ciudadesCheck', 'maximaDistancia'));
    }

    public function filtrar(){
        $ciudades = ['Bogotá', 'Medellin'];
        //TODO colocar las ciudades
        $ciudadesCheck = request()->ciudadesCheck;
        if(request()->distancia != null){
            $maximaDistancia = request()->distancia;
        }else{
            $maximaDistancia = request()->distanciaSmall;
        }

        $entrenadores  = User::where('rol', Constantes::ROL_ENTRENADOR)
            ->whereHas('entrenador', function ($q){
                $q->where('tarifa', '<>', '');
            })->when($ciudadesCheck, function ($query, $ciudadesCheck){
                 $query->whereIn('ciudad', $ciudadesCheck);
            })->get();
        return view('busquedaEntrenadores', compact('entrenadores', 'ciudades', 'ciudadesCheck', 'maximaDistancia'));
    }

    public function irOfertar(SolicitudServicio $solicitud){
        SeguridadController::verificarRol('entrenador');
        if($solicitud->estado != 0 && $solicitud->estado != 5){//no está ni activa ni modificada
            request()->session()->flash('alert-danger', Constantes::ESTADO_INCORRECTO_VER_OFERTA);
            return back();
        }
        $usuario = Auth::id();
        return view('ofertar', compact('solicitud', 'usuario'));
    }
}
