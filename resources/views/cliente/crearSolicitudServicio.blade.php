@extends('cliente.formSolicitudServicio')

@section('title') Crear Solicitud @endsection

@section('form')
    <form id="solicitudForm" method="POST" action="{{route('crearSolicitud')}}" autocomplete="off">
        @csrf
        @parent
        @section('titulo') Crear solicitud de entrenamiento @endsection
    </form>
@endsection