@extends('cliente.clienteTemplate')

@section('title') Busqueda @endsection

@section('head-content')

    <!-- Se debe poner esta de nuevo para que funcion el tooltip (SE QUITÓ PORQUE NO VEO NADA CON TOOLTIP Y ESTO CAUSA QUE LOS DROPDOWN NO APAREZCAN AL PRIMER CLICK)
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>-->

    <link rel="stylesheet" href="{{asset('css/busquedaClientes.css')}}">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">


    <link rel="stylesheet" href="https://code.jquery.com/ui/1.11.3/themes/hot-sneaks/jquery-ui.css" />

@endsection

@section('content')

    <!--Maps-->
    <script>
        var map;
        var marker;

        function initMap() {
            map = new google.maps.Map(document.getElementById('map'), {
                center: {lat: -34.397, lng: 150.644},
                zoom: 16
            });
        }

        function cargarUbicacion(solicitud) {

            initMap();

            var location = {
                lat: Number(solicitud.latitud),
                lng: Number(solicitud.longitud)
            };

            crearMarker(map, location);

            map.setCenter(location);
        }

        function crearMarker(map, location, draggable) {
            marker = new google.maps.Marker({
                position:location,
                draggable:draggable,
                map:map
            });
        }
    </script>
    <script
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDjn6uQjll2HhwGi8L5_QTs4bAxAjqh5E0&libraries=geometry&callBack=initMap">
    </script>

    <!--slide listener-->
    <script>
        $(document).ready(function() {

            var slide = document.getElementById("slideDistancia"),
                labelDistancia = document.getElementById("labelDistancia");

            labelDistancia.innerHTML = "<" + {{$maximaDistancia}};

            slide.addEventListener("input", function() {
                labelDistancia.innerHTML = "<" + slide.value;
            }, false);

            /*FOR SMALL*/
            var slideSmall = document.getElementById("slideDistancia-sm"),
                labelDistanciaSmall = document.getElementById("labelDistancia-sm");

            labelDistanciaSmall.innerHTML = "<" + {{$maximaDistancia}};

            slideSmall.addEventListener("input", function() {
                labelDistanciaSmall.innerHTML = "<" + slideSmall.value;
            }, false);

        });

        function filtrarDistancia(small=false) {
            navigator.permissions.query({name: 'geolocation'}).then(function(status) {
                if(status.state != 'granted'){
                    alert('Para usar el filtro de distancia debes permitir la ubicación');
                }else {
                    if(small){
                        document.getElementById('filtrarProyectosForm-sm').submit();
                    }else {
                        document.getElementById('filtrarProyectosForm').submit();
                    }
                }
            });
        }
    </script>

    <div class="container-fluid">

        <!--mostrar direccion-->
        <script>
            $(document).ready(function() {
                $('#mapModal').on('shown.bs.modal', function (event) {
                    var button = $(event.relatedTarget);
                    document.getElementById('direccion').innerHTML = button.data('direccion');
                });
            });
        </script>
        <!-- Modal maps-->
        <div class="modal fade" id="mapModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Ubicacion <br/><small id="direccion"></small></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div id="map" style="height:80vh;"></div>
                    </div>
                </div>
            </div>
        </div>

        @if ($errors->has('latitud') or $errors->has('longitud'))
            <script>
                alert('Para usar el filtro de distancia debes permitir tu ubicación')
            </script>
        @endif

        <div class="ml-2 mr-2 mb-3 d-md-none dropdown">
            <button class="btn btn-block bg-third dropdown-toggle"  type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Filtros</button>
            <div class="dropdown-menu filtros floating-card bg-dark" aria-labelledby="dropdownMenuButton">
                <form id="filtrarProyectosForm-sm" method="POST" action="{{route('buscarProyecto.filtrar')}}" novalidate autocomplete="off">
                    <!--el novalidate evita los mensaje de validación del navegador-->
                    @csrf

                    <h4>Distancia</h4>
                    <br>
                    <div class="mb-3">
                        <input id="slideDistancia-sm" name="distanciaSmall" onchange="filtrarDistancia(true)" type="range" class="slider" min="0" max="50" value="{{$maximaDistancia}}" style="width: 70%">
                        <!--<div id="slideDistancia" style="width: 80%" class="slider"></div>-->
                        <p id="labelDistancia-sm" class="d-inline-block"></p>
                        <p class="d-inline-block">Km</p>
                    </div>

                    <h4>Ciudades</h4>
                    <br>
                    <div id="filtro-ciudades">
                        @foreach($ciudades as $ciudad)
                            <div class="form-check">
                                <label class="check-container">{{$ciudad}}
                                    <input type="checkbox" name="ciudadesCheck[]" value="{{$ciudad}}" onchange="this.form.submit();" {{ in_array($ciudad, ($ciudadesCheck == null ? [] : $ciudadesCheck)) ? 'checked' : '' }}>
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                        @endforeach
                    </div>

                    <h4>Categorias</h4>
                    <br>
                    <div id="filtro-tags">
                        @foreach($tags as $tag)
                            <div class="form-check">
                                <label class="check-container">{{$tag->descripcion}}
                                    <input type="checkbox" name="tagsCheck[]" value="{{$tag->id}}" onchange="this.form.submit();" {{ in_array($tag->id, ($tagsCheck == null ? [] : $tagsCheck)) ? 'checked' : '' }}>
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                        @endforeach
                    </div>
                </form>
            </div>
        </div>

        <div id="filtros" class="filtros ml-4 floating-card bg-semi-transparent d-none d-md-inline-block">
            <form id="filtrarProyectosForm" method="POST" action="{{route('buscarProyecto.filtrar')}}" novalidate autocomplete="off">
                <!--el novalidate evita los mensaje de validación del navegador-->
                @csrf

                <h4>Distancia</h4>
                <br>
                <div class="mb-3">
                    <input id="slideDistancia" name="distancia" onchange="filtrarDistancia()" type="range" class="slider" min="0" max="50" value="{{$maximaDistancia}}" style="width: 65%">
                    <p id="labelDistancia" class="d-inline-block"></p>
                    <p class="d-inline-block">Km</p>
                </div>

                <h4>Ciudades</h4>
                <br>
                <div id="filtro-ciudades">
                    @foreach($ciudades as $ciudad)
                        <div class="form-check">
                            <label class="check-container">{{$ciudad}}
                                <input type="checkbox" name="ciudadesCheck[]" value="{{$ciudad}}" onchange="this.form.submit();" {{ in_array($ciudad, ($ciudadesCheck == null ? [] : $ciudadesCheck)) ? 'checked' : '' }}>
                                <span class="checkmark"></span>
                            </label>
                        </div>
                    @endforeach
                </div>

                <h4>Categorias</h4>
                <br>
                <div id="filtro-tags">
                    @foreach($tags as $tag)
                        <div class="form-check">
                            <label class="check-container">{{$tag->descripcion}}
                                <input type="checkbox" name="tagsCheck[]" value="{{$tag->id}}" onchange="this.form.submit();" {{ in_array($tag->id, ($tagsCheck == null ? [] : $tagsCheck)) ? 'checked' : '' }}>
                                <span class="checkmark"></span>
                            </label>
                        </div>
                    @endforeach
                </div>
            </form>
        </div>

        <div id="right-container">
            @if($solicitudes->isEmpty())
                <div class="margenes-normales floating-card bg-semi-transparent">
                    <p class="d-inline-block">No parece haber solicitudes, prueba con otro filtro o intenta más tarde.</p>
                </div>
            @endif

            @foreach($solicitudes as $solicitud)
                <script>
                    var posicionActual;

                    calcularDistancia();

                    function calcularDistancia() {
                        // Try HTML5 geolocation.
                        if (navigator.geolocation) {
                            navigator.geolocation.getCurrentPosition(function (position) {
                                if(posicionActual == undefined) {
                                    posicionActual = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
                                }

                                var x1 = new google.maps.LatLng({!! $solicitud->latitud !!},{!! $solicitud->longitud !!});

                                var distancia = google.maps.geometry.spherical.computeDistanceBetween(x1, posicionActual);

                                if(distancia > {{ $maximaDistancia }}*1000){//distancia en metros
                                    $('#solicitud{{$solicitud->id}}').remove();
                                }
                                var medida = 'Km';
                                if (distancia > 1000) {
                                    distancia = (distancia / 1000).toFixed(1);
                                } else {
                                    distancia = distancia.toFixed(0);
                                    medida = 'metros';
                                }
                                $('#distancia{!! $solicitud->id !!}').append('- ' + distancia + ' ' + medida);
                            });
                        }
                    }
                </script>

                <div id="solicitud{{$solicitud->id}}" class="solicitud-container d-flex floating-card bg-semi-transparent borde-negro-intenso">
                    <div class="service-description d-inline-block">
                        <div class="d-inline-block">
                            <h3>{{$solicitud->titulo}}</h3>
                        </div>
                        <div class="d-inline-block">
                            <a class="cursor-pointer" onclick="cargarUbicacion({{$solicitud}})" data-toggle="modal" data-target="#mapModal" data-direccion="{{$solicitud->direccion}}">
                                <img class="client-icon d-inline-block" alt="lugar" src="{{asset('images/placeholder.png')}}">
                                <p class="d-inline-block">{{$solicitud->ciudad}}</p>

                                <p id="distancia{{$solicitud->id}}" class="d-inline-block" style="color: grey"></p>
                            </a>
                        </div>
                        <div class="mt-3 mb-3">
                            @if($solicitud->horarios()->exists())
                                    <div class="event-information">
                                        <h4>Evento:</h4>
                                    </div>
                                    <div class="event-information">
                                        @foreach($solicitud->horarios as $horario)
                                            <p class="event-schedule">{{$horario->diaEvento()}} ({{$horario->fecha->format('d-M')}})
                                                {{$horario->hora_inicio->format('g:i A')}} - {{$horario->hora_fin->format('g:i A')}}</p>
                                        @endforeach
                                    </div>
                            @endif
                            @isset($solicitud->programacion)
                                <div class="event-information">
                                    <strong>Desde: </strong>{{$solicitud->programacion->fecha_inicio->format('d-m-Y')}}
                                    <span class="d-block d-md-inline-block ml-md-3"><strong>Hasta: </strong>{{$solicitud->programacion->fecha_finalizacion->format('d-m-Y')}}</span>
                                </div>
                                <div class="event-information d-block">
                                    <div class="event-information">
                                        @isset($solicitud->programacion->lunes)
                                            <span class="d-block">Lunes {{$solicitud->programacion->hora_inicio_lunes->format('g:i A')}} - {{$solicitud->programacion->hora_fin_lunes->format('g:i A')}}</span>
                                        @endisset
                                        @isset($solicitud->programacion->martes)
                                            <span class="d-block">Martes {{$solicitud->programacion->hora_inicio_martes->format('g:i A')}} - {{$solicitud->programacion->hora_fin_martes->format('g:i A')}}</span>
                                        @endisset
                                        @isset($solicitud->programacion->miercoles)
                                            <span class="d-block">Miércoles {{$solicitud->programacion->hora_inicio_miercoles->format('g:i A')}} - {{$solicitud->programacion->hora_fin_miercoles->format('g:i A')}}</span>
                                        @endisset
                                        @isset($solicitud->programacion->jueves)
                                            <span class="d-block">Jueves {{$solicitud->programacion->hora_inicio_jueves->format('g:i A')}} - {{$solicitud->programacion->hora_fin_jueves->format('g:i A')}}</span>
                                        @endisset
                                        @isset($solicitud->programacion->viernes)
                                            <span class="d-block">Viernes {{$solicitud->programacion->hora_inicio_viernes->format('g:i A')}} - {{$solicitud->programacion->hora_fin_viernes->format('g:i A')}}</span>
                                        @endisset
                                        @isset($solicitud->programacion->sabado)
                                            <span class="d-block">Sábado {{$solicitud->programacion->hora_inicio_sabado->format('g:i A')}} - {{$solicitud->programacion->hora_fin_sabado->format('g:i A')}}</span>
                                        @endisset
                                        @isset($solicitud->programacion->domingo)
                                            <span class="d-block">Domingo {{$solicitud->programacion->hora_inicio_domingo->format('g:i A')}} - {{$solicitud->programacion->hora_fin_domingo->format('g:i A')}}</span>
                                        @endisset
                                    </div>
                                </div>
                            @endisset
                        </div>

                        <p class="d-lg-none mt-3 mb-3">
                            <small>{{$solicitud->descripcion}}</small>
                        </p>
                        <p class="d-none d-lg-block mt-3 mb-3">{{$solicitud->descripcion}}</p>
                        <div class="mt-3 mb-3">
                            @foreach($solicitud->tags as $ltag)
                                <div class="tag">
                                    <p>{{$ltag->tag->descripcion}}</p>
                                </div>
                            @endforeach
                        </div>
                        <p class="mt-3 mb-3">{{$solicitud->ofrecimientos->count()}} propuestas</p>
                        <div class="user-info-horizontal mt-3 mb-3 mb-md-1">
                            <a class="client-icon" href="{{route('visitarPerfil', ['user'=> $solicitud->cliente->usuario->slug])}}">
                                <img class="rounded-circle" width="100%" height="100%" alt="user" src="{{asset('images/avatars/'.$solicitud->cliente->usuario->foto)}}">
                            </a>
                            <p>{{$solicitud->cliente->usuario->nombre}}</p>
                            <div class="rating-container">
                                <img id="emptyRating" alt="rating" src="{{asset('images/empty_rating.png')}}">
                                <div class="fullRating-container" style="min-width: calc(64px*{{$solicitud->cliente->usuario->ratingPorcentage()}}); max-width: calc(100px*{{$solicitud->cliente->usuario->ratingPorcentage()}}); width: calc(10vw*{{$solicitud->cliente->usuario->ratingPorcentage()}});"></div>
                            </div>
                        </div>
                        <a class="btn apply-sm d-block d-md-none bg-base" href="{{ route('ofertar', ['solicitud' => $solicitud])}}">Aplicar</a>
                    </div>
                    <a class="btn apply-lg d-none d-md-block ml-auto bg-base" href="{{ route('ofertar', ['solicitud' => $solicitud]) }}">Aplicar</a>
                </div>
            @endforeach
        </div>
    </div>

    <!--sticky scrolling-->
    <script>

        var $details = $("#filtros");
        var lastScrollTop = 0;
        var fixedDown = false;
        var fixedUp= false;
        var topPosition = 0;
        var bottomPosition = 0;
        var scrollingHeight = $details.height()+$("#top-navbar").height()- $( window ).height() + 74;
        $(window).on("scroll", function() {
            var st = $(window).scrollTop();
            if (st > lastScrollTop){//scroll down
                if(fixedUp){
                    topPosition = $(window).scrollTop();
                    $details.css("position", "absolute").css("top",topPosition).css("bottom", "");
                    fixedUp = false;
                }else{
                    if($('#right-container').height() < $( window ).height()){
                        return false;
                    }
                    if ($(window).scrollTop() > topPosition + scrollingHeight) {
                        $details.css("position", "fixed").css("bottom", 0).css("top", "");
                        fixedDown = true;
                    }
                }
            } else {//scroll up
                if(fixedDown){
                    bottomPosition = -$(window).scrollTop();
                    //$details.css("position", "absolute").css("top", $(window).scrollTop()-72).css("bottom", "");
                    $details.css("position", "absolute").css("top", "").css("bottom", bottomPosition-$( window ).height()+$("#top-navbar").height()+56);
                    fixedDown = false;
                }else{
                    if ($(window).scrollTop() < -(bottomPosition+scrollingHeight)) {
                        $details.css("position", "fixed").css("top", $("#top-navbar").height()+56).css("bottom", "");
                        fixedUp = true;
                    }
                }
            }
            lastScrollTop = st;
        });
    </script>



@endsection
