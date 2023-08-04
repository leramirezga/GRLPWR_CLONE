@extends('sessions.formSession')

@section('title') Crear Sesión @endsection

@section('form')
    <form id="sessionForm" method="POST" action="{{route('eventos.store')}}" autocomplete="off">
        @csrf
        @parent
        @section('titulo') Crear sesión de entrenamiento @endsection
    </form>
@endsection