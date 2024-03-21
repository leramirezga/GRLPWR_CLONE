@extends('layouts.app')

@section('title')
    Valoración de bienestar 365
@endsection

@push('head-content')
    <link href="{{asset('css/range.css')}}" rel="stylesheet"/>
@endpush

@section('content')
    <form id="healthTestForm" method="post" action="{{route('wellBeingTest',  ['user'=> $user])}}" enctype="multipart/form-data">
        @method('POST')
        @csrf

        <div class="col-10 col-lg-6 m-auto">

            <h1 class="text-center">Valoración Física</h1>
            <x-input name="weight" description="Peso (Kg)" type="number" required step=".01"></x-input>
            <x-input name="muscle" description="Músculo" type="number" required step=".01"></x-input>
            <x-input name="visceral_fat" description="Grasa Visceral" type="number" required step=".01"></x-input>
            <x-input name="body_fat" description="Grasa Corporal" type="number" required step=".01"></x-input>
            <x-input name="water_level" description="Nivel agua:" type="number" required step=".01"></x-input>
            <x-input name="proteins" description="Proteínas:" type="number" required step=".01"></x-input>
            <x-input name="basal_metabolism" description="Metabolismo Basal:" type="number" required step=".01"></x-input>
            <x-input name="bone_mass" description="Masa Ósea:" type="number" required step=".01"></x-input>
            <x-input name="body_score" description="Puntuación Corporal:" type="number" required step=".01"></x-input>

            <h1 class="text-center">Alimentación</h1>
            <x-range name="feeding_relationship" description="De 1 a 10, ¿Cómo es tu relación con tu alimentación?" min="1" max="10" required></x-range>
            <x-input name="breakfast" description="¿Qué desayunas?" type="text" required></x-input>
            <x-input name="mid_morning" description="¿Qué comes en la media mañana?" type="text" required></x-input>
            <x-input name="lunch" description="¿Qué almuerzas?" type="text" required></x-input>
            <x-input name="snacks" description="¿Qué comes a media tarde?" type="text" required></x-input>
            <x-input name="dinner" description="¿Qué cenas?" type="text" required></x-input>
            <x-input name="happy_food" description="¿Qué comes cuando estás feliz?" type="text" required></x-input>
            <x-input name="sad_food" description="¿Qué comes cuando estás triste?" type="text" required></x-input>
            <x-input name="supplements" description="¿Tomas/Comes suplementos?" type="text" required></x-input>
            <x-input name="medicines" description="¿Tomas medicinas?" type="text" required></x-input>

            <h1 class="text-center">Preferencias de entrenamiento</h1>
            <div class="form-group row">
                <label for="training_frequency" class="col-md-4 col-form-label text-md-center">¿Con qué frecuencia realizas actividad física?</label>
                <div class="col-md-6">
                    <select class="form-control pl-1 color-white bg-dark" id="training_frequency" name="training_frequency">
                        <option value="" disabled selected>Selecciona...</option>
                        <option value="nunca" >Nunca</option>
                        <option value="1" >1 vez por semana</option>
                        <option value="2-3" >2 a 3 vez por semana</option>
                        <option value="+3" >+3 veces por semana</option>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label for="training_frequency" class="col-md-4 col-form-label text-md-center">¿Qué intensidad prefieres a la hora de entrenar?</label>
                <div class="col-md-6">
                    <select class="form-control pl-1 color-white bg-dark" id="training_intensity" name="training_intensity">
                        <option value="" disabled selected>Selecciona...</option>
                        <option value="low" >baja</option>
                        <option value="medium" >media</option>
                        <option value="high" >alta</option>
                    </select>
                </div>
            </div>
            <x-input name="music" description="¿Con qué música te gusta entrenar?" type="text" required></x-input>

            <h1 class="text-center">Mentalidad</h1>
            <x-input name="body_discomfort" description="¿Hay alguna parte de tu cuerpo que te haga sentir incómoda o que quieras mejorar?" type="text" required></x-input>
            <x-raddio name="stress" description="¿Experimentas estrés, ansiedad o algún otro desafío de salud mental?" checked="1" showReason="1" reason="¿Cúal?" required></x-raddio>
            <x-raddio name="stress_practice" description="¿Participas en prácticas de manejo del estrés o bienestar mental?" checked="1" showReason="1" reason="¿Cúal?" required></x-raddio>
            <x-raddio name="spiritual_belief" description="¿Tienes alguna creencia espiritual o filosofía de vida que te sea importante?" checked="1" showReason="1" reason="¿Cúal?" required></x-raddio>
            <x-raddio name="spiritual_practice" description="¿Participas en prácticas espirituales o de meditación?" checked="1" showReason="1" reason="¿Cúal?" required></x-raddio>

            <h1 class="text-center">¿Cómo te sientes en tu vida?</h1>
            <x-range name="health" description="Salud: ¿Estás contenta con tu fortaleza física y mental?" min="1" max="10" showReason="1" reason="¿Por qué?" required></x-range>
            <x-range name="personal_growth" description="Desarrollo Personal: ¿Te sientes realizada con lo que quieres hacer?" min="1" max="10" showReason="1" reason="¿Por qué?" required></x-range>
            <x-range name="home" description="Hogar: ¿Estás satisfecha en el sitio donde vives?" min="1" max="10" showReason="1" reason="¿Por qué?" required></x-range>
            <x-range name="family_and_friends" description="Familia y amigos: ¿Estás satisfecha con tu círculo social?" min="1" max="10" showReason="1" reason="¿Por qué?" required></x-range>
            <x-range name="love" description="Amor: ¿En qué medida hay armonía en tu vida sentimental?" min="1" max="10" showReason="1" reason="¿Por qué?" required></x-range>
            <x-range name="leisure" description="Ocio: ¿Cuánto te llena el tiempo libre que tienes?" min="1" max="10" showReason="1" reason="¿Por qué?" required></x-range>
            <x-range name="work" description="Trabajo: ¿Qué grado de satisfacción profesional tienes? " min="1" max="10" showReason="1" reason="¿Por qué?" required></x-range>
            <x-range name="money" description="Dinero: ¿Estás contenta con el dinero que manejas?" min="1" max="10" showReason="1" reason="¿Por qué?" required></x-range>

            <button class="btn btn-success d-flex my-3 mx-auto" type="submit">Enviar Valoración</button>
        </div>
    </form>
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

