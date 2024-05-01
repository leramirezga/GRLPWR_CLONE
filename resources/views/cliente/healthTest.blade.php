@extends('layouts.app')

@section('title')
    Valoración de bienestar 365
@endsection

@push('head-content')
    <link href="{{asset('css/range.css')}}" rel="stylesheet"/>
@endpush

@section('content')

        <div class="col-10 col-lg-6 m-auto">
            @include('cliente.physicalTest')
            <div class="mt-5"></div>
            @include('cliente.foodTest')
            <div class="mt-5"></div>
            @include('cliente.trainingTest')
            <div class="mt-5"></div>
            @include('cliente.wellBeingTest')
            <div class="mt-5"></div>
            @include('cliente.wheelOfLifeTest')
            <div class="mt-5"></div>
        </div>

@endsection

@push('scripts')
    <script>
        document.querySelectorAll('input[type="range"]').forEach(function (element) {
            // Función para actualizar el valor mostrado junto al slider
            function updateSliderValue() {
                var sliderValueId = this.name + '-value';
                document.getElementById(sliderValueId).textContent = this.value;
            }

            // Inicializar el valor mostrado al cargar la página
            updateSliderValue.call(element);

            // Escuchar cambios en el slider y actualizar el valor mostrado
            element.addEventListener('input', updateSliderValue);
        });
    </script>
@endpush

