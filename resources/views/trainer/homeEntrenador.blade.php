@extends('layouts.home')

@section('title')
    Mi Perfil
@endsection

@section('generoEntrenador')
    <div class="input-group">
        <span class="iconos">
            <i class="fas fa-venus-mars"></i>
        </span>
        <div class="radio">
            <label class="radio-label">
                <input required type="radio" name="genero"
                       value="f" {{$user->genero != null && $user->genero == 'f' ? "checked=true" : ""}}>
                Femenino
            </label>
        </div>
        <div class="radio">
            <label class="radio-label">
                <input type="radio" name="genero"
                       value="m" {{$user->genero != null && $user->genero == 'm' ? "checked=true" : ""}}>
                Masculino
            </label>
        </div>
    </div>
@endsection

@section('tab2AditionalContent')
    <div class="col-sm-12">
        <div class="form-group">
            <label for="comment">Escribe una pequeña carta de presentación para que te conozcan tus clientes.:</label>
            <textarea name="descripcion" maxlength="140" class="form-control h-auto" rows="5"
                      id="comment">{{$user->descripcion}}</textarea>
        </div>
    </div>
@endsection

@section('tab3Title')
    Información Laboral
@endsection

@section('tab3Content')
    <div class="row">
        <h4 class="info-text">¿Cuanto cobras por hora?</h4>
        <div class="col-sm-6 m-auto">
            <div class="input-group">
                <span class="iconos">
                    <i class="material-icons">attach_money</i>
                </span>
                <div class="form-group label-floating">
                    <label class="control-label">Tarifa <small>(requerido)</small></label>
                    <input name="tarifa" required type="number" step="any" class="form-control"
                           value="@isset($user->entrenador){{$user->entrenador->tarifa}}@endisset">
                </div>
            </div>
        </div>
        <h4 class="info-text mb-0">¿Donde recibirás tus pagos?</h4>
        <h5 class="grey info-text"><small>(Opcional)</small></h5>
        <div class="col-sm-4">
            <div class="input-group">
                <span class="input-group-addon iconos">
                    <i class="fas fa-piggy-bank"></i>
                </span>
                <div class="form-group label-floating">
                    <label class="control-label">Tipo de cuenta</label>
                    <select class="form-control" name="tipoCuenta">
                        <option disabled selected value style="display:none"></option>
                        <option value="0" {{$user->entrenador != null && $user->entrenador->tipo_cuenta === 0 ? "selected" : ""}}>
                            Ahorros
                        </option>
                        <!--tipo_cuenta === 0 par que cuando exista el entrenador y la cuenta sea nula no la deje en ahorros-->
                        <option value="1" {{$user->entrenador != null && $user->entrenador->tipo_cuenta == 1 ? "selected" : ""}}>
                            Corriente
                        </option>
                    </select>
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="input-group">
                <span class="input-group-addon iconos">
                    <i class="fas fa-university"></i>
                </span>
                <div class="form-group label-floating">
                    <label class="control-label">Banco</label>
                    <select class="form-control" name="banco">
                        <option disabled selected value style="display:none"></option>
                        <option {{$user->entrenador != null && $user->entrenador->banco == "BANCO AGRARIO" ? "selected" : ""}}>
                            BANCO AGRARIO
                        </option>
                        <option {{$user->entrenador != null && $user->entrenador->banco == "BANCO AV VILLAS" ? "selected" : ""}}>
                            BANCO AV VILLAS
                        </option>
                        <option {{$user->entrenador != null && $user->entrenador->banco == "BANCO CAJA SOCIAL" ? "selected" : ""}}>
                            BANCO CAJA SOCIAL
                        </option>
                        <option {{$user->entrenador != null && $user->entrenador->banco == "BANCO COLPATRIA" ? "selected" : ""}}>
                            BANCO COLPATRIA
                        </option>
                        <option {{$user->entrenador != null && $user->entrenador->banco == "BANCO DAVIVIENDA" ? "selected" : ""}}>
                            BANCO DAVIVIENDA
                        </option>
                        <option {{$user->entrenador != null && $user->entrenador->banco == "BANCO DE BOGOTA" ? "selected" : ""}}>
                            BANCO DE BOGOTA
                        </option>
                        <option {{$user->entrenador != null && $user->entrenador->banco == "BANCO DE OCCIDENTE" ? "selected" : ""}}>
                            BANCO DE OCCIDENTE
                        </option>
                        <option {{$user->entrenador != null && $user->entrenador->banco == "BANCO GNB SUDAMERIS" ? "selected" : ""}}>
                            BANCO GNB SUDAMERIS
                        </option>
                        <option {{$user->entrenador != null && $user->entrenador->banco == "BANCO PICHINCHA S.A." ? "selected" : ""}}>
                            BANCO PICHINCHA S.A.
                        </option>
                        <option {{$user->entrenador != null && $user->entrenador->banco == "BANCO POPULAR" ? "selected" : ""}}>
                            BANCO POPULAR
                        </option>
                        <option {{$user->entrenador != null && $user->entrenador->banco == "BANCO PROCREDIT" ? "selected" : ""}}>
                            BANCO PROCREDIT
                        </option>
                        <option {{$user->entrenador != null && $user->entrenador->banco == "BANCOLOMBIA" ? "selected" : ""}}>
                            BANCOLOMBIA
                        </option>
                        <option {{$user->entrenador != null && $user->entrenador->banco == "BANCOOMEVA S.A." ? "selected" : ""}}>
                            BANCOOMEVA S.A.
                        </option>
                        <option {{$user->entrenador != null && $user->entrenador->banco == "BBVA COLOMBIA S.A." ? "selected" : ""}}>
                            BBVA COLOMBIA S.A.
                        </option>
                        <option {{$user->entrenador != null && $user->entrenador->banco == "CITIBANK" ? "selected" : ""}}>
                            CITIBANK
                        </option>
                        <option {{$user->entrenador != null && $user->entrenador->banco == "ITAÚ" ? "selected" : ""}}>
                            ITAÚ
                        </option>
                        <option {{$user->entrenador != null && $user->entrenador->banco == "BANCO FALABELLA" ? "selected" : ""}}>
                            BANCO FALABELLA
                        </option>
                    </select>
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="input-group">
                <span class="input-group-addon iconos">
                    <i class="fas fa-hashtag"></i>
                </span>
                <div class="form-group label-floating">
                    <label class="control-label">Cuenta <small></small></label>
                    <input name="numeroCuenta" type="number" step="any" class="form-control"
                           value="@isset($user->entrenador){{$user->entrenador->numero_cuenta}}@endisset">
                </div>
            </div>
        </div>
    </div>
@endsection

@section('tipoUsuario')
    Entrenador
@endsection

@section('card1')
    <div class="floating-card bg-semi-transparent p-3 mb-3">
        <h3 class="d-inline-block mb-5">Blogs:</h3>
        @if(!$user->blogs->isEmpty())
            <a class="btn btn-success float-right" href="{{route('blogsUsuario', ['user'=> $user])}}">Ver Todos</a>

        @else
            @if(!$visitante)
                <button class="btn btn-success float-right" data-toggle="modal" data-target="#crearInfoBlogModal">
                    Escribir Blog
                </button>
                <p class="d-inline-block mt-3 mb-3">Aún no has escrito un blog. Publica uno para que más atletas te
                    conozcan y te encuentren en las búsquedas!</p>
            @else
                <p class="d-inline-block mt-3 mb-3">El entrenador no ha publicado blogs aún, pero puedes encontrar
                    artículos interesantes en nuestra <a class="coral" href="{{route('blogs')}}">sección de blogs!</a>
                </p>
            @endif
        @endif
    </div>

    @if(!$visitante)
        @include('entrenamientosAgendados')

        <div class="floating-card bg-semi-transparent p-3 mb-3">
            <div class="mb-5">
                <h3 class="d-inline-block">Ofrecimientos:</h3>
                @if(!$solicitudes->isEmpty())
                    <a class="btn btn-success float-right" href="{{route('buscarProyecto')}}">
                        Buscar clientes
                    </a>
                @endif
            </div>

            @include('solicitudesAbiertas')
        </div>
    @endif
@endsection

@section('card2')
    @include('estadisticasEntrenador')
@endsection