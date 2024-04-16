<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Auth\SeguridadController;
use App\Model\Ofrecimientos;
use App\Model\SolicitudServicio;
use App\Model\Tags;
use App\Utils\Constantes;
use Illuminate\Support\Facades\Auth;

class BusquedaProyectoController extends Controller
{


    public function buscarProyectos(){
        SeguridadController::verificarRol('entrenador');
        $tags = Tags::all();
        $ciudades = ['Bogotá', 'Medellin'];

        $tagsCheck = null;
        $ciudadesCheck = null;
        $maximaDistancia = 25;//Carga 25 kilometros por defecto

        $solicitudes = SolicitudServicio::whereIn('estado', [0, 5])->get();//solicitud activa o modificada;//TODO filtrar por la ciudad donde se registró el entrenador y mostra checked esa ciudad
        return view('cliente.busquedaClientes', compact('solicitudes', 'tags', 'tagsCheck', 'ciudades', 'ciudadesCheck', 'maximaDistancia'));
    }

    public function filtrar(){
        $tags = Tags::all();
        $ciudades = ['Bogotá', 'Medellin'];
        //TODO colocar las ciudades
        $tagsCheck = request()->tagsCheck;
        $ciudadesCheck = request()->ciudadesCheck;
        if(request()->distancia != null){
            $maximaDistancia = request()->distancia;
        }else{
            $maximaDistancia = request()->distanciaSmall;
        }

        $solicitudes = SolicitudServicio::whereIn('estado', [0, 5])->ciudades($ciudadesCheck)->tag($tagsCheck)->get();//Solo muestra las activas o modificadas
        return view('cliente.busquedaClientes', compact('solicitudes', 'tags', 'tagsCheck', 'ciudades', 'ciudadesCheck', 'maximaDistancia'));

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

    public function crearOferta(SolicitudServicio $solicitud){
        $ofrecimiento = Ofrecimientos::where('solicitud_servicio_id', $solicitud->id)
                        ->where('usuario_id', Auth::id())->first();

        if($ofrecimiento != null){
            request()->session()->flash('alert-danger', Constantes::MENSAJE_PROPUESTA_DUPLICADA);
            return back();
        }
        $data = request()->validate( [
            'precio' => 'required|numeric',
            'precioTotal' => 'required|numeric',
            ]);
        Ofrecimientos::create([
            'solicitud_servicio_id' => $solicitud->id,
            'usuario_id' => Auth::id(),
            'precio' => $data['precioTotal'],
        ]);
        request()->session()->flash('alert-success', Constantes::MENSAJE_PROPUESTA_PUBLICADA);
        return back();
    }

    public function actualizarOferta(){
        $ofrecimiento = Ofrecimientos::find(request()->ofertaID);
        if($ofrecimiento->solicitudServicio->estado != Constantes::SOLICITUD_SERVICIO_ESTADO_ACTIVO && $ofrecimiento->solicitudServicio->estado != Constantes::SOLICITUD_SERVICIO_ESTADO_MODIFICADA){
            request()->session()->flash('alert-danger', Constantes::MENSAJE_ESTADO_INCORRECTO_EDITAR_OFERTA);
            return redirect()->route('home', ['user' => Auth::user()]);
        }
        $ofrecimiento->precio = request()->precioTotalActualizar;
        $ofrecimiento->estado = 0;//por si la solicitud había sido modificada
        $ofrecimiento->save();
        request()->session()->flash('alert-success', Constantes::MENSAJE_PROPUESTA_ACTUALIZADA);
        return back();
    }

    public function eliminarOferta(){
        $ofrecimiento = Ofrecimientos::find(request()->ofertaIDEliminar);
        if($ofrecimiento->solicitudServicio->estado != 0 || $ofrecimiento->solicitudServicio->estado != 5){
            request()->session()->flash('alert-danger', Constantes::MENSAJE_ESTADO_INCORRECTO_ELIMINAR_OFERTA);
            return redirect()->route('home', ['user' => Auth::user()]);
        }
        $ofrecimiento->delete();//usa soft delete
        request()->session()->flash('alert-error', 'Tu propuesta fue eliminada!');
        return back();
    }

    public function confirmarOferta(){
        $ofrecimiento = Ofrecimientos::find(request()->ofertaIDConfirmar);
        if($ofrecimiento->solicitudServicio->estado != 0 || $ofrecimiento->solicitudServicio->estado != 5){
            request()->session()->flash('alert-danger', Constantes::MENSAJE_ESTADO_INCORRECTO_CONFIRMAR_OFERTA);
            return redirect()->route('home', ['user' => Auth::user()]);
        }
        $ofrecimiento->estado = 0;
        $ofrecimiento->save();
        return back();
    }
}
