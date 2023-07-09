    <h3 class="mb-5">Estadísticas:</h3>


    <!--Si se colocan más de dos para que se muestren una debajo de la otra class="d-sm-block d-md-flex"-->

    <div style="justify-content: space-around;" class="d-flex">
        <div class="contador-container">
            <div class="numero-contador-container">
                <h2 class="counter-count">{{$user->nivel}}</h2>
            </div>
            <h4>NIVEL</h4>
        </div>

        @stack('counters')
    </div>

    @stack('statistics_content')
