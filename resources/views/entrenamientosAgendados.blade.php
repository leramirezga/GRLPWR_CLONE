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
                    <p id="advertenciaPenalidad">Cancelar el entrenamiento no garantiza un reembolso. Debes comunicarte con el entrenador para usar tu saldo de cancelación </p>
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
            <div class="solicitud-container d-md-flex floating-card bg-semi-transparent mb-3">
                <div>
                    <p class="d-block">{{$entrenamiento->nombre}}</p>
                    <p class="d-block">{{$entrenamiento->fecha_inicio}}</p>
                    <p class="d-block">Lugar: {{$entrenamiento->lugar}}</p>
                    @isset($entrenamiento->SKU)
                        <p class="d-block">Kangoo: {{$entrenamiento->SKU}}</p>
                    @endisset
                </div>
            <div class="ml-auto">
                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#cancelarEntrenamientoModal" onclick="prepararCancelarEntrenamiento({{$entrenamiento->id}})">Cancelar</button>
                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#reviewModal" onclick="asignarReview()">Finalizar</button>
            </div>
            </div>
        @endforeach
    @else
        <div class="solicitud-container d-md-flex floating-card bg-semi-transparent mb-3">
            <p>Aún no tienes entrenamientos agendados</p>
        </div>
    @endif
</div>

@push('scripts')

    <script>
        <!---->
        function prepararCancelarEntrenamiento(sessionId) {
            document.getElementById('entrenamientoCancelar').value= sessionId;
        }
        <!--Review-->
        function asignarReview(entrenamientoAgendado) {
            document.getElementById('entrenamientoReview').value= entrenamientoAgendado.id;
            document.getElementById('rating').value= null;
            $('#ratingSeleccionado').css('width', '0');
        }
    </script>
            @endpush

