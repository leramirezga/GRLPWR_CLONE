@extends('layouts.auth')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="floating-card form">
                <div class="card-body">

                    <form method="POST" action="{{ route('register') }}" aria-label="{{ __('Register') }}">
                        @csrf
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus>

                                @if ($errors->has('name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>

                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!--
                        <div class="form-group row">
                            <label for="role" class="d-inline-block col-md-4 col-form-label text-md-right">{{ __('Role') }}</label>
                            <div class="col-md-6">
                                <select class="foroptionm-control" id="role" name="role">
                                    < value="cliente">Atleta</option>
                                    <option>Entrenador</option>
                                </select>
                            </div>
                        </div>
                        -->

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary" style="width: inherit" onclick="gtag_report_conversion()">
                                    Registrarme
                                </button>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <br />
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="aceptacion" id="aceptacion" required>

                                    <label class="form-check-label" for="aceptacion">
                                        <small>He leido y acepto los <a style="text-decoration: none" href="javascript:void(0);" data-toggle="modal" data-target="#modalTerminos"><b><u>Términos de Servicio</u></b></a> y el <a style="text-decoration: none" href="javascript:void(0);" data-toggle="modal" data-target="#modalConsentimiento"><b><u>Consentimiento Informado</u></b></a></small>
                                    </label>
                                </div>

                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal terminos y condiciones-->
<div class="modal" tabindex="-1" role="dialog" id="modalTerminos">
    <div role="document" class="h-100">
        <div class="modal-content h-100">
            <div class="modal-header h-100">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <embed src="{{asset('pdf/terminos_y_condiciones.pdf')}}" width="100%" height="100%" />
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal" tabindex="-1" role="dialog" id="modalConsentimiento">
    <div role="document" class="h-100">
        <div class="modal-content h-100">
            <div class="modal-header h-100">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <embed src="{{asset('pdf/Consentimiento informado.pdf')}}" width="100%" height="100%" />
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection
