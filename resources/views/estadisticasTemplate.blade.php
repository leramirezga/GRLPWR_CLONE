<div class="floating-card bg-semi-transparent p-3 mb-3">
    <h3 class="mb-5">Estadísticas:</h3>


    <!--Si se colocan más de dos para que se muestren una debajo de la otra class="d-sm-block d-md-flex"-->

    <div style="justify-content: space-around;" class="d-flex">
        <div class="contador-container">
            <div class="numero-contador-container">
                <h2 class="counter-count">{{$user->entrenamientosRealizados()->count()}}</h2>
            </div>
            <h4>ENTRENAMIENTOS</h4>
        </div>

        @yield('contador2')
    </div>
</div>