@extends('layouts.app')

@section('title')
    Busqueda Entrenador
@endsection

@section('head-content')

    <!-- Se debe poner esta de nuevo para que funcion el tooltip (SE QUITÓ PORQUE NO VEO NADA CON TOOLTIP Y ESTO CAUSA QUE LOS DROPDOWN NO APAREZCAN AL PRIMER CLICK)
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>-->

    <link rel="stylesheet" href="{{asset('css/busquedaClientes.css')}}">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">


    <link rel="stylesheet" href="https://code.jquery.com/ui/1.11.3/themes/hot-sneaks/jquery-ui.css"/>

@endsection

@section('content')

    <div class="container-fluid">

        <div class="ml-2 mr-2 mb-3 d-md-none dropdown">
            <button class="btn btn-block bg-third dropdown-toggle" type="button" id="dropdownMenuButton"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Filtros
            </button>
            <div class="dropdown-menu filtros floating-card bg-dark" aria-labelledby="dropdownMenuButton">
                <form id="filtrarEntrenaodresForm-sm" method="POST" action="{{route('buscarEntrenadores.filtrar')}}"
                      novalidate autocomplete="off">
                    <!--el novalidate evita los mensaje de validación del navegador-->
                    @csrf

                    <h4>Ciudades</h4>
                    <br>
                    <div id="filtro-ciudades">
                        @foreach($ciudades as $ciudad)
                            <div class="form-check">
                                <label class="check-container">{{$ciudad}}
                                    <input type="checkbox" name="ciudadesCheck[]" value="{{$ciudad}}"
                                           onchange="this.form.submit();" {{ in_array($ciudad, ($ciudadesCheck == null ? [] : $ciudadesCheck)) ? 'checked' : '' }}>
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                        @endforeach
                    </div>
                </form>
            </div>
        </div>

        <div id="filtros" class="filtros ml-4 floating-card bg-semi-transparent d-none d-md-inline-block">
            <form id="filtrarEntrenadoresForm" method="POST" action="{{route('buscarEntrenadores.filtrar')}}" novalidate
                  autocomplete="off">
                <!--el novalidate evita los mensaje de validación del navegador-->
                @csrf

                <h4>Ciudades</h4>
                <br>
                <div id="filtro-ciudades" class="mb-5">
                    @foreach($ciudades as $ciudad)
                        <div class="form-check">
                            <label class="check-container">{{$ciudad}}
                                <input type="checkbox" name="ciudadesCheck[]" value="{{$ciudad}}"
                                       onchange="this.form.submit();" {{ in_array($ciudad, ($ciudadesCheck == null ? [] : $ciudadesCheck)) ? 'checked' : '' }}>
                                <span class="checkmark"></span>
                            </label>
                        </div>
                    @endforeach
                </div>
            </form>
        </div>

        <div id="right-container" class="row">
            @if($entrenadores->isEmpty())
                <div class="margenes-normales floating-card bg-semi-transparent">
                    <p class="d-inline-block">No parece haber entrenadores, prueba con otro filtro o intenta más
                        tarde.</p>
                </div>
            @endif

            @foreach($entrenadores as $entrenador)
                <div id="entrenador{{$entrenador->id}}"
                     class="entrenador-container solicitud-container text-center col-md-3 d-md-inline-block floating-card bg-semi-transparent borde-negro-intenso"
                     onclick="window.location='{{route('visitarPerfil', ['user'=> $entrenador->slug])}}'">
                    <img src="{{asset('images/avatars/'.$entrenador->foto)}}?{{time()}}" class="user-profile-icon">

                    <div class="verificado-container d-flex justify-content-around" style="height: 36px">
                        <!--el mismo height que tiene el icono como font-size para que no se sobreponga con otros elementos-->
                        @if($entrenador->reviews->count() < 5 && $entrenador->rating() < 4)
                            <h6 class="nuevo-tag">NUEVO</h6>
                        @endif
                        @if($entrenador->verificado)
                            <i class="fas fa-check-circle verificado">
                                <div></div>
                            </i>
                        @endif
                    </div>
                    <h4 class="mt-3">{{$entrenador->nombre}} {{$entrenador->apellido_1}}</h4>
                    @if($entrenador->reviews->count() >= 5 || $entrenador->rating() >= 4)
                        <img style="width: 100px; height: 25px; margin-bottom: 0" alt="rating"
                             src="{{asset('images/empty_rating.png')}}">
                        <div style="margin: 0 auto; width: 100px; height: 1px">
                            <div class="fullRating-container"
                                 style="width: calc(100px*{{$entrenador->ratingPorcentage()}}); height: 25px; margin-top: -25px;"></div>
                        </div>
                    @endif
                    <p class="grey mb-3">{{$entrenador->reviews->count()}} reviews</p>
                    @isset($entrenador->entrenador)
                        <p class="mb-3">$ {{$entrenador->entrenador->tarifa}} / Hora</p>
                    @endisset
                    <div style="height: 40px">
                        <!--la altura máxima del boton, para que no se sobreponga cuando la altura del card es automatica-->
                        <a class="btn btn-success bottom"
                           onclick="window.location='{{route('home', ['user'=> $entrenador->nivel])}}'">Contratar</a>
                    </div>
                </div>
            @endforeach
            <!--para que tome el click del botón y no el del div-->
            <script>
                $(".bottom").click(function (e) {
                    e.stopPropagation();
                });
            </script>
        </div>
    </div>

    <!--sticky scrolling-->
    <script>

        var $details = $("#filtros");
        var lastScrollTop = 0;
        var fixedDown = false;
        var fixedUp = false;
        var topPosition = 0;
        var bottomPosition = 0;
        var scrollingHeight = $details.height() + $("#top-navbar").height() - $(window).height() + 74;
        $(window).on("scroll", function () {
            var st = $(window).scrollTop();
            if (st > lastScrollTop) {//scroll down
                if (fixedUp) {
                    topPosition = $(window).scrollTop();
                    $details.css("position", "absolute").css("top", topPosition).css("bottom", "");
                    fixedUp = false;
                } else {
                    if ($('#right-container').height() < $(window).height()) {
                        return false;
                    }
                    if ($(window).scrollTop() > topPosition + scrollingHeight) {
                        $details.css("position", "fixed").css("bottom", 0).css("top", "");
                        fixedDown = true;
                    }
                }
            } else {//scroll up
                if (fixedDown) {
                    bottomPosition = -$(window).scrollTop();
                    //$details.css("position", "absolute").css("top", $(window).scrollTop()-72).css("bottom", "");
                    $details.css("position", "absolute").css("top", "").css("bottom", bottomPosition - $(window).height() + $("#top-navbar").height() + 56);
                    fixedDown = false;
                } else {
                    if ($(window).scrollTop() < -(bottomPosition + scrollingHeight)) {
                        $details.css("position", "fixed").css("top", $("#top-navbar").height() + 56).css("bottom", "");
                        fixedUp = true;
                    }
                }
            }
            lastScrollTop = st;
        });
    </script>

@endsection
