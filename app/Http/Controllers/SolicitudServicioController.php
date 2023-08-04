<?php

namespace App\Http\Controllers;

use App\Model\HorarioSolicitudServicio;
use App\Model\Ofrecimientos;
use App\Model\ProgramacionSolicitudServicio;
use App\Model\SolicitudServicio;
use App\Model\Tags;
use App\Model\TagsSolicitudServicio;
use App\Model\TutorialRealizado;
use App\Notifications\SolicitudCancelada;
use App\Notifications\SolicitudEditada;
use App\User;
use App\Utils\Constantes;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\SeguridadController;
use Illuminate\Support\Facades\Notification;
use App\Model\Review;
use Validator;

class SolicitudServicioController extends Controller
{

    public function show(User $user, SolicitudServicio $solicitud){
        SeguridadController::verificarPermisos($user, Constantes::ROL_CLIENTE);
        if($solicitud->estado != 0 && $solicitud->estado != 5){//estado diferente de activa o modificada
            request()->session()->flash('alert-info', 'Lo sentimos la solicitud no está disponible');
            return back();
        }
        if($solicitud->cliente()->first() == null || $solicitud->cliente()->first()->usuario_id != $user->id){
            abort(403, 'usuario incorrecto');
        }
        return view('cliente.solicitudServicio', compact('solicitud'));
    }

    public function irCrear(){
        SeguridadController::verificarRol(Constantes::ROL_CLIENTE);
        $id = Auth::id();
        $tutorialPendiente = TutorialRealizado::
            where('usuario_id', $id)
            ->where('tutorial_id', 1)
            ->get()->isEmpty();
        return view('cliente.crearSolicitudServicio', compact('tutorialPendiente'));
    }

    public function irEditar(User $user, SolicitudServicio $solicitud){
        SeguridadController::verificarPermisos($user, Constantes::ROL_CLIENTE);
        //Además de comprobar que el usuario de la URL es quien está logeado comprueba que el usuario de la URL sea el dueño de la solicitud
        if($solicitud->cliente()->first() == null || $solicitud->cliente()->first()->usuario_id != $user->id){
            abort(403, 'usuario incorrecto');
        }
        $tags = $solicitud -> tags();
        return view('cliente.editarSolicitudServicio', compact('solicitud', 'tags'));
    }

    public function validar(){//hay que validar por si hacen el submit del formulario desocultando el botón de finalizar o usando otro método
        $rules = [
            'titulo' => 'required|string',
            'descripcion' => 'nullable|string',
            'tag' => 'required|string',
            'tags' => 'nullable|string',
            'cantidadSesiones' => 'required',

            'ciudad' => 'required',
            'latitud' => 'required|numeric',
            'longitud' => 'required|numeric',
            'direccion' => 'nullable',

            //Varias sesiones
            'diasSemana' => 'required_if:cantidadSesiones,'.Constantes::VARIAS_SESIONES,
        ];
        $messages = [
            'ciudad.required' => 'debes seleccionar el lugar donde deseas recibir el entrenamiento',
            'latitud.required' => 'debes seleccionar el lugar donde deseas recibir el entrenamiento',
            'longitud.required' => 'debes seleccionar el lugar donde deseas recibir el entrenamiento',
        ];
        //UNICA SESION
        if ( request()->input('cantidadSesiones')== Constantes::UNICA_SESION){
            $rules['fecha'] = 'required|date_format:d/m/Y';
            $rules['horaInicio'] = 'required|date_format:h:i A';
            $rules['horaFin'] = 'required|date_format:h:i A|after:horaInicio';
        }

        //VARIAS SESIONES
        if ( request()->input('cantidadSesiones')== Constantes::VARIAS_SESIONES) {
            $rules['fechaInicio'] = 'required|date_format:d/m/Y';
            $rules['fechaFin'] = 'required|date_format:d/m/Y|after:fechaInicio';

            if (in_array('1', request()->input('diasSemana', []))) {
                $rules['horaInicioLunes'] = 'required|date_format:h:i A';
                $rules['horaFinLunes'] = 'required|date_format:h:i A|after:horaInicioLunes';
            }
            if (in_array('2', request()->input('diasSemana', []))) {
                $rules['horaInicioMartes'] = 'required|date_format:h:i A';
                $rules['horaFinMartes'] = 'required|date_format:h:i A|after:horaInicioMartes';
            }
            if (in_array('3', request()->input('diasSemana', []))) {
                $rules['horaInicioMiércoles'] = 'required|date_format:h:i A';
                $rules['horaFinMiércoles'] = 'required|date_format:h:i A|after:horaInicioMiércoles';
            }
            if (in_array('4', request()->input('diasSemana', []))) {
                $rules['horaInicioJueves'] = 'required|date_format:h:i A';
                $rules['horaFinJueves'] = 'required|date_format:h:i A|after:horaInicioJueves';
            }
            if (in_array('5', request()->input('diasSemana', []))) {
                $rules['horaInicioViernes'] = 'required|date_format:h:i A';
                $rules['horaFinViernes'] = 'required|date_format:h:i A|after:horaInicioViernes';
            }
            if (in_array('6', request()->input('diasSemana', []))) {
                $rules['horaInicioSábado'] = 'required|date_format:h:i A';
                $rules['horaFinSábado'] = 'required|date_format:h:i A|after:horaInicioSábado';
            }
            if (in_array('7', request()->input('diasSemana', []))) {
                $rules['horaInicioDomingo'] = 'required|date_format:h:i A';
                $rules['horaFinDomingo'] = 'required|date_format:h:i A|after:horaInicioDomingo';
            }
        }
        $validator = Validator::make(request()->all(), $rules, $messages);
        return $validator->validate();
    }

    public function save(){
        $data = $this->validar();
        //TODO antes de crear SOLO EN SAVE NO EN EL METODO CREAR PORQUE SE UTILIZA EN EDITAR TAMBIEN, verificar que no tenga otra solicitud que se cruce (alcance fuera del MPV)
        $solicitudCreada = SolicitudServicio::create(
            [
                'usuario_id' => Auth::id(),
                'titulo' => $data['titulo'],
                'descripcion' => $data['descripcion'],
                'ciudad' => $data['ciudad'],
                'direccion' => $data['direccion'],
                'latitud' => $data['latitud'],
                'longitud' => $data['longitud'],
                'estado' => 0,
                'tipo' => $data['cantidadSesiones'],
            ]
        );
        if($data['cantidadSesiones']==Constantes::UNICA_SESION){
            HorarioSolicitudServicio::create(
                [
                    'solicitud_servicio_id' => $solicitudCreada->id,
                    'fecha' => date('Y-m-d', strtotime(str_replace('/', '-', $data['fecha']))),
                    'hora_inicio' => date('H:i:s', strtotime($data['horaInicio'])),
                    'hora_fin' => date('H:i:s', strtotime($data['horaFin'])),
                    'estado' => 0,
                ]
            );
        }
        elseif($data['cantidadSesiones']==Constantes::VARIAS_SESIONES){
            $programacion = new ProgramacionSolicitudServicio;

            $programacion->solicitud_servicio_id=$solicitudCreada->id;
            $programacion->fecha_inicio = date('Y-m-d', strtotime(str_replace('/', '-', $data['fechaInicio'])));
            $programacion->fecha_finalizacion = date('Y-m-d', strtotime(str_replace('/', '-', $data['fechaFin'])));

            foreach ($data['diasSemana'] as $dia){
                switch ($dia){
                    case 1:
                        $programacion->lunes =   true;
                        $programacion->hora_inicio_lunes = date('H:i:s', strtotime( $data['horaInicioLunes']));
                        $programacion->hora_fin_lunes = date('H:i:s', strtotime( $data['horaFinLunes']));
                        break;
                    case 2:
                        $programacion->martes =   true;
                        $programacion->hora_inicio_martes = date('H:i:s', strtotime( $data['horaInicioMartes']));
                        $programacion->hora_fin_martes = date('H:i:s', strtotime( $data['horaFinMartes']));
                        break;
                    case 3:
                        $programacion->miercoles =   true;
                        $programacion->hora_inicio_miercoles = date('H:i:s', strtotime( $data['horaInicioMiércoles']));
                        $programacion->hora_fin_miercoles = date('H:i:s', strtotime( $data['horaFinMiércoles']));
                        break;
                    case 4:
                        $programacion->jueves=   true;
                        $programacion->hora_inicio_jueves = date('H:i:s', strtotime( $data['horaInicioJueves']));
                        $programacion->hora_fin_jueves = date('H:i:s', strtotime( $data['horaFinJueves']));
                        break;
                    case 5:
                        $programacion->viernes =   true;
                        $programacion->hora_inicio_viernes = date('H:i:s', strtotime( $data['horaInicioViernes']));
                        $programacion->hora_fin_viernes = date('H:i:s', strtotime( $data['horaFinViernes']));
                        break;
                    case 6:
                        $programacion->sabado =   true;
                        $programacion->hora_inicio_sabado = date('H:i:s', strtotime( $data['horaInicioSábado']));
                        $programacion->hora_fin_sabado = date('H:i:s', strtotime( $data['horaFinSábado']));
                        break;
                    case 7:
                        $programacion->domingo =   true;
                        $programacion->hora_inicio_domingo = date('H:i:s', strtotime( $data['horaInicioDomingo']));
                        $programacion->hora_inicio_domingo = date('H:i:s', strtotime( $data['horaInicioDomingo']));
                        break;
                }
            }

            $programacion->save();
        }
        $this->crearTags($solicitudCreada->id, $data);
        return redirect()->route('home', ['user' => Auth::user()]);
    }

    public function crearTags($idSolicitud, $data){

        if($data['tags']==null){
            $tags = array();
        }else{
            $tags = explode(',',$data['tags']);
        }
        array_push($tags, $data['tag']);
        foreach ($tags as $tag){
            $tagExistente = Tags::where('descripcion', $tag)->get()->first();
            if(!$tagExistente){
                $tagExistente = Tags::create(
                    [
                        'descripcion' => $tag,
                    ]
                );
            }
            TagsSolicitudServicio::create(
                [
                    'tag_id' => $tagExistente->id,
                    'solicitud_servicio_id' => $idSolicitud,
                ]
            );
        }
    }

    public function editar(SolicitudServicio $solicitud){
        $data = $this->validar();

        $solicitud ->titulo = $data['titulo'];
        $solicitud ->descripcion = $data['descripcion'];
        $solicitud ->ciudad = $data['ciudad'];
        $solicitud ->direccion = $data['direccion'];
        $solicitud ->latitud = $data['latitud'];
        $solicitud ->longitud = $data['longitud'];
        $solicitud ->estado = 5;//estado modificada
        $solicitud->tipo = $data['cantidadSesiones'];
        $solicitud->save();

        $solicitud->programacion()->delete();//Siempre se elimina, si es unica sesión ya no se necesita (no hace nada si no existe) si es de multiple sesión se borra porque actualizar no es efectivo (hay que cambiar todos los campos)
        $solicitud->horarios()->delete();

        if($data['cantidadSesiones']==Constantes::UNICA_SESION) {
            HorarioSolicitudServicio::updateOrCreate(
                ['solicitud_servicio_id' => $solicitud->id],
                [
                    'fecha' => date('Y-m-d', strtotime(str_replace('/', '-', $data['fecha']))),
                    'hora_inicio' => date('H:i:s', strtotime($data['horaInicio'])),
                    'hora_fin' => date('H:i:s', strtotime($data['horaFin'])),
                    'estado' => Constantes::HORARIOS_SOLICITUD_SERVICIO_ESTADO_ACTIVO,
                ]
            );
        }elseif ($data['cantidadSesiones']==Constantes::VARIAS_SESIONES){
            $programacion = new ProgramacionSolicitudServicio;

            $programacion->solicitud_servicio_id=$solicitud->id;
            $programacion->fecha_inicio = date('Y-m-d', strtotime(str_replace('/', '-', $data['fechaInicio'])));
            $programacion->fecha_finalizacion = date('Y-m-d', strtotime(str_replace('/', '-', $data['fechaFin'])));

            foreach ($data['diasSemana'] as $dia){
                switch ($dia){
                    case 1:
                        $programacion->lunes =   true;
                        $programacion->hora_inicio_lunes = date('H:i:s', strtotime( $data['horaInicioLunes']));
                        $programacion->hora_fin_lunes = date('H:i:s', strtotime( $data['horaFinLunes']));
                        break;
                    case 2:
                        $programacion->martes =   true;
                        $programacion->hora_inicio_martes = date('H:i:s', strtotime( $data['horaInicioMartes']));
                        $programacion->hora_fin_martes = date('H:i:s', strtotime( $data['horaFinMartes']));
                        break;
                    case 3:
                        $programacion->miercoles =   true;
                        $programacion->hora_inicio_miercoles = date('H:i:s', strtotime( $data['horaInicioMiércoles']));
                        $programacion->hora_fin_miercoles = date('H:i:s', strtotime( $data['horaFinMiércoles']));
                        break;
                    case 4:
                        $programacion->jueves=   true;
                        $programacion->hora_inicio_jueves = date('H:i:s', strtotime( $data['horaInicioJueves']));
                        $programacion->hora_fin_jueves = date('H:i:s', strtotime( $data['horaFinJueves']));
                        break;
                    case 5:
                        $programacion->viernes =   true;
                        $programacion->hora_inicio_viernes = date('H:i:s', strtotime( $data['horaInicioViernes']));
                        $programacion->hora_fin_viernes = date('H:i:s', strtotime( $data['horaFinViernes']));
                        break;
                    case 6:
                        $programacion->sabado =   true;
                        $programacion->hora_inicio_sabado = date('H:i:s', strtotime( $data['horaInicioSábado']));
                        $programacion->hora_fin_sabado = date('H:i:s', strtotime( $data['horaFinSábado']));
                        break;
                    case 7:
                        $programacion->domingo =   true;
                        $programacion->hora_inicio_domingo = date('H:i:s', strtotime( $data['horaInicioDomingo']));
                        $programacion->hora_inicio_domingo = date('H:i:s', strtotime( $data['horaInicioDomingo']));
                        break;
                }
            }

            $programacion->save();
        }

        TagsSolicitudServicio::where('solicitud_servicio_id', $solicitud->id)->delete();
        $this->crearTags($solicitud->id, $data);

        $users = User::whereHas('ofrecimientos', function($q) use ($solicitud){
            $q->where('solicitud_servicio_id', $solicitud->id);
        })->get();

        Ofrecimientos::where('solicitud_servicio_id', $solicitud->id)
            ->update(['estado' => 2]);//solicitud modificada

        //Elimina las notificaciones anterios de la misma solicitud para que no se llene de notificaciones repetidas
        //(Sin embargo la persona podría pensar que se le perfieron notificaciones)
        //\App\Notification::where('data', 'like', "%\"id\":".$solicitud->id."%")->delete();

        Notification::send($users, new SolicitudEditada($solicitud));

        request()->session()->flash('alert-success', 'Tu solicitud fue editada, si tenias ofertas deben esperar que los entrenadores confirmen su oferta!');
        return redirect()->route('home', ['user' => Auth::user()]);
    }

    public function tutorialCreacionCompletado(){
        TutorialRealizado::create([
            'usuario_id' => Auth::id(),
            'tutorial_id' => 1
        ]);
    }

    public function eliminar(){
        $solicitud = SolicitudServicio::find(request()->solicitudIDEliminar);
        $solicitud->delete();
        request()->session()->flash('alert-danger', 'Tu solicitud fue eliminada!');
        return back();
    }

    public function finalizarSolicitud(){
        $user = Auth::user();
        $entrenamiento = HorarioSolicitudServicio::find(request()->entrenamientoReview);
        if(strcasecmp ($user->rol, Constantes::ROL_CLIENTE ) == 0){
            $entrenamiento->finalizado_cliente = true;
            $usuarioReview = Ofrecimientos::find($entrenamiento->solicitudServicio->oferta_aceptada)->usuario_id;
        }
        if(strcasecmp ($user->rol, Constantes::ROL_ENTRENADOR) == 0){
            $entrenamiento->finalizado_entrenador = true;
            $usuarioReview = $entrenamiento->solicitudServicio->usuario_id;
        }
        $entrenamiento->save();
        if(request()->rating != null){
            Review::create([
                'usuario_id' => $usuarioReview,
                'rating' => request()->rating,
                'review' => request()->review,
                'reviewer_id' => Auth::id(),
            ]);
        }
        return back();
    }

    public function cancelarEntrenamiento(){
        $entrenamiento = HorarioSolicitudServicio::find(request()->entrenamientoCancelar);
        //Se verifica que esté activo, para que si el usuario lo canceló el entrenador no pueda también cancelarlo y viceversa
        if($entrenamiento->estado != Constantes::HORARIOS_SOLICITUD_SERVICIO_ESTADO_ACTIVO){
            request()->session()->flash('alert-info', Constantes::MENSAJE_ENTRENAMIENTO_YA_CANCELADO);
            return back();
        }

        if($entrenamiento->fecha->format('Y-m-d') == now()->format('Y-m-d')){
            $diferencia = now()->diffInSeconds($entrenamiento->hora_inicio, false);
            if($diferencia <= 0){
                request()->session()->flash('alert-info', Constantes::MENSAJE_CANCELACION_TARDIA);
                return back();
            }
        }elseif ($entrenamiento->fecha < now()){
            request()->session()->flash('alert-info', Constantes::MENSAJE_CANCELACION_TARDIA);
            return back();
        }

        $entrenamiento->estado = Constantes::HORARIOS_SOLICITUD_SERVICIO_ESTADO_CANCELADO;
        $entrenamiento->usuario_cancelacion = Auth::id();
        $entrenamiento->canceled_at = now();
        $entrenamiento->save();

        request()->session()->flash('alert-success', Constantes::MENSAJE_CANCELACION_EXITOSA);
        if(strcasecmp (Auth::user()->rol, Constantes::ROL_CLIENTE ) == 0){
            $entrenamiento->solicitudServicio->ofertaAceptada->entrenador->notify(new SolicitudCancelada($entrenamiento->solicitudServicio));
        }
        if(strcasecmp (Auth::user()->rol, 'entrenador' ) == 0){
            $entrenamiento->solicitudServicio->cliente->usuario->notify(new SolicitudCancelada($entrenamiento->solicitudServicio));
        }
        return back();
    }

}
