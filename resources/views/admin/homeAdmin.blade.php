@extends('layouts.app')

@section('title')
    Admin
@endsection


@section('modals')

    <!--solicitud modal ELIMINAR-->
    <!--Solo se utiliza para clientes ya que los entrenadores pueder ir a la info de la solictud y eliminar su oferta-->
    <div class="modal fade" id="solicitudModalEliminar" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="eliminarSolicitudForm" method="post"
                      action="{{route('eliminarSolicitud', ['user'=> Auth::user()->slug])}}"
                      autocomplete="off">
                    @method('DELETE')
                    @csrf

                    <input type="hidden" name="solicitudIDEliminar" id="solicitudIDEliminar">

                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Confirmar eliminación</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>¿Está seguro que desea eliminar su solicitud?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-danger">Eliminar</button>
                        <button type="button" class="btn btn-success" data-dismiss="modal"
                                aria-label="Close">Cancelar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="{{\Illuminate\Support\Facades\Blade::check('feature', 'dark_theme', false) ? "floating-card bg-semi-transparent" : ""}} p-3 mb-3">
        <div class="mb-5">
            <h3>Próximas sesiones:</h3>
        </div>
        @include('proximasSesiones')
    </div>
@endsection