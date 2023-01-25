<!--Cancelar entrenamiento modal-->
<div class="modal fade" id="cancelarEntrenamientoModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="cancelarEntrenamientoForm" method="post" action="{{route('cancelarEntrenamiento')}}" autocomplete="off">
                @method('DELETE')
                @csrf

                <input type="hidden" name="entrenamientoCancelar" id="entrenamientoCancelar">

                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Confirmar cancelación</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>¿Estás seguro que deseas cancelar el entrenamiento?</p>
                    <br/>
                    <p id="advertenciaPenalidad"></p>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger">Seguro</button>
                    <button type="button" class="btn btn-success" data-dismiss="modal" aria-label="Close">Volver</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="floating-card bg-semi-transparent p-3 mb-3">
    <div class="mb-5">
        <h3>Entrenamientos agendados:</h3>
    </div>
    @if(!$entrenamientosAgendados->isEmpty())
        @foreach($entrenamientosAgendados as $entrenamiento)
            @foreach($entrenamiento->horariosAgendados as $horario)
                <div class="solicitud-container d-md-flex floating-card bg-semi-transparent mb-3">
                    <div>
                        <p class="d-block">{{$horario->diaEvento()}} ({{$horario->fecha->format('d-M')}})
                            {{$horario->hora_inicio->format('g:i A')}} - {{$horario->hora_fin->format('g:i A')}}</p>

                        <div class="user-info-horizontal mt-3 mb-3 mb-md-1">
                            <a class="client-icon" href="{{route('visitarPerfil', ['user'=> $user->rol == 'cliente' ? $entrenamiento->ofertaAceptada->entrenador->slug : $entrenamiento->cliente->usuario->slug])}}">
                                <img class="rounded-circle" width="100%" height="100%" alt="user" src="{{$user->rol == 'cliente' ? asset('images/avatars/'.$entrenamiento->ofertaAceptada->entrenador->foto) : asset('images/avatars/'.$entrenamiento->cliente->usuario->foto)}}">
                            </a>
                            @if($user->rol == 'cliente')
                                <p>{{$entrenamiento->ofertaAceptada->entrenador->nombre}} {{$entrenamiento->ofertaAceptada->entrenador->apellido_1}}</p>
                            @else
                                <p>{{$entrenamiento->cliente->usuario->nombre}} {{$entrenamiento->cliente->usuario->apellido_1}}</p>
                            @endif
                        </div>
                    </div>
                    <div class="ml-auto">
                        @if(($user->rol == \App\Utils\Constantes::ROL_CLIENTE && $horario->finalizado_entrenador == 0) || ($user->rol == \App\Utils\Constantes::ROL_ENTRENADOR && $horario->finalizado_cliente == 0))
                            @if($horario-> fecha->format('Y-m-d') == now()->format('Y-m-d'))
                                @if($horario-> hora_inicio > now())
                                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#cancelarEntrenamientoModal" onclick="prepararCancelarEntrenamiento()">Cancelar</button>
                                @endif
                            @elseif($horario-> fecha > now())
                                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#cancelarEntrenamientoModal" onclick="prepararCancelarEntrenamiento({{$horario}})">Cancelar</button>
                            @endif
                        @endif
                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#reviewModal" onclick="asignarReview({{$horario}})">Finalizar</button>
                    </div>
                </div>
            @endforeach
        @endforeach
    @else
        <div class="solicitud-container d-md-flex floating-card bg-semi-transparent mb-3">
            <p>Aún no tienes entrenamientos agendados</p>
        </div>
    @endif
</div>

<!--Review-->
<script>
    function asignarReview(entrenamientoAgendado) {
        document.getElementById('entrenamientoReview').value= entrenamientoAgendado.id;
        document.getElementById('rating').value= null;
        $('#ratingSeleccionado').css('width', '0');
    }
</script>

<!--Cancelar entrenamiento-->
<script>
    function prepararCancelarEntrenamiento(horario) {
        document.getElementById('entrenamientoCancelar').value=horario.id;
        var now= Date.now();
        var hora = new Date('1970-01-01T'+horario.hora_inicio.date.substring(11)+'Z').getTime();
        var fecha = new Date(horario.fecha.date).getTime();
        var fechaCompuesta = fecha+hora;
        var diferencia = (fechaCompuesta-now)/(1000*60*60);
        var rol = "{{ $user->rol }}";
        if(diferencia < 24){
            document.getElementById('advertenciaPenalidad').innerHTML= rol == "cliente" ? "Por ser una cancelación con menos de 24 horas de anticipación puede que se te cobre parte del entrenamiento" : "Por ser una cancelación con menos de 24 horas de anticipación puede que seas sancionado";
        }
        else{
            document.getElementById('advertenciaPenalidad').innerHTML= "";
        }
    }
</script>