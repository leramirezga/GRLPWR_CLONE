@extends('layouts.app')

@section('title')
    Tipo usuario
@endsection

@section('head-content')
@endsection

@section('content')

    <script>
        $(document).ready(function () {
            $('#tipoUsuarioModal').modal({show: true});
        });
    </script>

    <div class="container">

        <!--modal seleccionar tipo usuario-->
        <div class="modal fade" id="tipoUsuarioModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
             aria-hidden="true" data-backdrop="static">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form id="tipoUsuarioForm" method="POST" action="{{route('completarRegistroRedesSociales')}}"
                          autocomplete="off">
                        @method('PUT')
                        @csrf

                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Tipo de usuario</h5>
                        </div>
                        <div class="modal-body">
                            <div class="form-group row">
                                <label for="role"
                                       class="d-inline-block col-md-4 col-form-label text-md-right">{{ __('Role') }}</label>
                                <div class="col-md-6">
                                    <select class="form-control" id="role" name="role">
                                        <option value="cliente">Atleta</option>
                                        <option value="entrenador">Entrenador</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success">Finalizar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


    </div>

@endsection
