@if($solicitudes->isEmpty())
    @if($user->rol == \App\Utils\Constantes::ROL_CLIENTE)
        @if($user->cliente == null)
            <div class="margenes-normales floating-card bg-semi-transparent d-block d-md-flex">
                <p class="mb-3 d-inline-block pr-md-4">Para poder crear solicitudes debes completar tu perfil.</p>
                <button class="btn themed-btn ml-auto btn-block" style="min-width: unset"  data-toggle="modal" data-target="#completarPerfilModal">Completar perfil</button>
            </div>
        @else
            <div class="margenes-normales floating-card bg-semi-transparent">
                <p class="d-inline-block mb-3">Parece que aún no has agendado un entrenamiento. No busques más excusas y empieza a entrenar. Vamos a alcanzar la meta!</p>
                <a class="btn themed-btn" href="{{route('crearSolicitud')}}">
                    Quiero Entrenar
                </a>
            </div>
        @endif
    @elseif($user->rol == \App\Utils\Constantes::ROL_ENTRENADOR)
        <div class="margenes-normales floating-card bg-semi-transparent">
            <p class="d-inline-block mb-3">Parece que aún no has ofrecido ningún entrenamiento. Busquemos usuarios para ayudarlos a alcanzar sus metas!</p>
            <a class="btn themed-btn" href="{{route('buscarProyecto')}}">
                Buscar clientes
            </a>
        </div>
    @endif
@else
    @foreach($solicitudes as $solicitud)
        <div class="solicitud-container d-md-flex floating-card bg-semi-transparent borde-blanco mb-3">
            <div>
                <div class="d-inline-block">
                    <h3>{{$solicitud->titulo}}</h3>
                </div>
                <div class="d-inline-block">
                    <a class="cursor-pointer" onclick="cargarUbicacion({{$solicitud}})" data-toggle="modal" data-target="#mapModal" data-direccion="{{$solicitud->direccion}}">
                        <img class="user-icon d-inline-block" alt="lugar" src="{{asset('images/placeholder.png')}}">
                        <p class="d-inline-block">{{$solicitud->ciudad}}</p>
                    </a>
                </div>
                <div class="mt-3 mb-3">
                    @if($solicitud->horarios()->exists())
                        <div class="event-information">
                            <h4>Evento:</h4>
                        </div>
                        <div class="event-information">
                            @foreach($solicitud->horarios as $horario)
                                <p class="event-schedule">{{$horario->diaEvento()}} ({{$horario->fecha->format('d-M')}})
                                    {{$horario->hora_inicio->format('g:i A')}} - {{$horario->hora_fin->format('g:i A')}}</p>
                            @endforeach
                        </div>
                    @endif
                    @isset($solicitud->programacion)
                        <div class="event-information">
                            <strong>Desde: </strong>{{$solicitud->programacion->fecha_inicio->format('d-m-Y')}}
                            <span class="d-block d-md-inline-block ml-md-3"><strong>Hasta: </strong>{{$solicitud->programacion->fecha_finalizacion->format('d-m-Y')}}</span>
                        </div>
                        <div class="event-information d-block">
                            <div class="event-information">
                                @isset($solicitud->programacion->lunes)
                                    <span class="d-block">Lunes {{$solicitud->programacion->hora_inicio_lunes->format('g:i A')}} - {{$solicitud->programacion->hora_fin_lunes->format('g:i A')}}</span>
                                @endisset
                                @isset($solicitud->programacion->martes)
                                    <span class="d-block">Martes {{$solicitud->programacion->hora_inicio_martes->format('g:i A')}} - {{$solicitud->programacion->hora_fin_martes->format('g:i A')}}</span>
                                @endisset
                                @isset($solicitud->programacion->miercoles)
                                    <span class="d-block">Miércoles {{$solicitud->programacion->hora_inicio_miercoles->format('g:i A')}} - {{$solicitud->programacion->hora_fin_miercoles->format('g:i A')}}</span>
                                @endisset
                                @isset($solicitud->programacion->jueves)
                                    <span class="d-block">Jueves {{$solicitud->programacion->hora_inicio_jueves->format('g:i A')}} - {{$solicitud->programacion->hora_fin_jueves->format('g:i A')}}</span>
                                @endisset
                                @isset($solicitud->programacion->viernes)
                                    <span class="d-block">Viernes {{$solicitud->programacion->hora_inicio_viernes->format('g:i A')}} - {{$solicitud->programacion->hora_fin_viernes->format('g:i A')}}</span>
                                @endisset
                                @isset($solicitud->programacion->sabado)
                                    <span class="d-block">Sábado {{$solicitud->programacion->hora_inicio_sabado->format('g:i A')}} - {{$solicitud->programacion->hora_fin_sabado->format('g:i A')}}</span>
                                @endisset
                                @isset($solicitud->programacion->domingo)
                                    <span class="d-block">Domingo {{$solicitud->programacion->hora_inicio_domingo->format('g:i A')}} - {{$solicitud->programacion->hora_fin_domingo->format('g:i A')}}</span>
                                @endisset
                            </div>
                        </div>
                    @endisset
                </div>

                <p class="d-lg-none mt-3 mb-3">
                    <small>{{$solicitud->descripcion}}</small>
                </p>
                <p class="d-none d-lg-block mt-3 mb-3">{{$solicitud->descripcion}}</p>
                <div class="mt-3 mb-3">
                    @foreach($solicitud->tags as $ltag)
                        <div class="tag">
                            <p>{{$ltag->tag->descripcion}}</p>
                        </div>
                    @endforeach
                </div>
                <p class="mt-3 mb-3">{{$solicitud->ofrecimientos->count()}} propuestas</p>
                @if($user->rol == \App\Utils\Constantes::ROL_CLIENTE)
                    <div class="d-flex d-md-none" style="justify-content: space-between">
                        <a class="btn bg-third fas fa-pencil-alt float-right mr-2" href="{{route('irEditarSolicitud', ['user' => $user, 'solicitud' => $solicitud])}}" style="width: -webkit-fill-available;"></a>
                        <button type="button" data-solicitudid="{{$solicitud->id}}" data-toggle="modal" data-target="#solicitudModalEliminar" class="btn bg-danger fa fa-trash float-right" style="width: -webkit-fill-available;"></button>
                    </div>
                    <a class="btn apply-sm d-block d-md-none bg-base" href="{{ route('solicitud', ['user' => $user, 'solicitud' => $solicitud])}}">Ver info</a>
                @elseif($user->rol == \App\Utils\Constantes::ROL_ENTRENADOR)
                    <div class="user-info-horizontal mt-3 mb-3 mb-md-1">
                        <a class="client-icon" href="{{route('visitarPerfil', ['user'=> $solicitud->cliente->usuario->slug])}}">
                            <img class="rounded-circle" width="100%" height="100%" alt="user" src="{{asset('images/avatars/'.$solicitud->cliente->usuario->foto)}}">
                        </a>
                        <p>{{$solicitud->cliente->usuario->nombre}}</p>
                        <div class="rating-container">
                            <img id="emptyRating" alt="rating" src="{{asset('images/empty_rating.png')}}">
                            <div class="fullRating-container" style="min-width: calc(64px*{{$solicitud->cliente->usuario->ratingPorcentage()}}); max-width: calc(100px*{{$solicitud->cliente->usuario->ratingPorcentage()}}); width: calc(10vw*{{$solicitud->cliente->usuario->ratingPorcentage()}});"></div>
                        </div>
                    </div>
                    <a class="btn apply-sm d-block d-md-none bg-base" href="{{ route('ofertar', ['solicitud' => $solicitud])}}">Ver info</a>
                @endif
            </div>
            @if($user->rol == \App\Utils\Constantes::ROL_CLIENTE)
                <div class="apply-lg d-none d-md-block ml-auto">
                    <a class="btn d-block mb-2 bg-base" style="width: 100%" href="{{ route('solicitud', ['user' => $user, 'solicitud' => $solicitud])}}">Ver info</a>
                    <button type="button" data-solicitudid="{{$solicitud->id}}" data-toggle="modal" data-target="#solicitudModalEliminar" class="btn bg-danger fa fa-trash float-right" style="min-width: unset;"></button>
                    <a class="btn bg-third fas fa-pencil-alt float-right mr-2" style="min-width: unset;" href="{{route('irEditarSolicitud', ['user' => $user, 'solicitud' => $solicitud])}}"></a>
                </div>
            @elseif($user->rol == \App\Utils\Constantes::ROL_ENTRENADOR)
                <a class="btn apply-lg d-none d-md-block ml-auto bg-base" href="{{ route('ofertar', ['solicitud' => $solicitud]) }}">Ver info</a>
            @endif
        </div>
    @endforeach
@endif