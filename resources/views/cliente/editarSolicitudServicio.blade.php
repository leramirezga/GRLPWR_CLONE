@extends('cliente.formSolicitudServicio')

@section('title') Editar Solicitud @endsection

@section('form')
    <form id="editarSolicitudForm" method="post" action="{{route('editarSolicitud', ['solicitud' => $solicitud])}}" autocomplete="off">
        @method('PUT')
        @csrf
        @parent
        @section('titulo') Editar solicitud de entrenamiento @endsection
    </form>
@endsection