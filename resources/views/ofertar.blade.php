@extends('layouts.app')

@section('title')
    Ofertar
@endsection

@section('head-content')
    <link rel="stylesheet" href="{{asset('css/ofertar.css')}}">
    <link rel="stylesheet" href="{{asset('css/solicitudServicio.css')}}">
@endsection

@section('content')

    <div class="container-fluid">
        <!-- Modal maps-->
        <div class="modal fade" id="mapModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Ubicacion <br/>
                            <small>{{$solicitud->direccion}}</small></h5>
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

        <!--oferta modal CREAR-->
        <div class="modal fade" id="ofertModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form id="crearPorpuestaForm" method="POST"
                          action="{{route('crearPropuesta', ['solicitud' => $solicitud])}}" novalidate
                          autocomplete="off">

                        <input type="hidden" name="precioTotal" id="precioTotal">

                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Oferta</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group row">
                                <label for="precio" class="col-6 col-form-label">Precio</label>
                                <div class="col-6">
                                    <input id="precio" type="number"
                                           class="text-right form-control{{ $errors->has('precio') ? ' is-invalid' : '' }}"
                                           name="precio" value="{{ old('precio') }}" required autofocus
                                           onkeyup="actualizarPrecioTotal(this)"
                                           onkeypress='return event.charCode >= 48 && event.charCode <= 57'/>
                                    @if ($errors->has('precio'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('precio') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="comision" class="col-6 col-form-label">Comisión</label>
                                <div class="col-6">
                                    <p id="comision" class="col-form-label text-right mr-3">20%</p>
                                </div>
                            </div>
                            <hr/>
                            <div class="form-group row">
                                <label for="total" class="col-6 col-form-label">Total</label>
                                <div class="col-6">
                                    <p id="total" class="col-form-label text-right mr-3">
                                        ${{number_format(0, 0, '.', ',')}}</p>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn themed-btn">Enviar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!--oferta modal ACTUALIZAR-->
        <div class="modal fade" id="ofertaModalActualizar" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form id="actualizarPorpuestaForm" method="post"
                          action="{{route('actualizarPropuesta', ['solicitud' => $solicitud])}}" autocomplete="off">
                        @method('PUT')
                        @csrf

                        <input type="hidden" name="precioTotalActualizar" id="precioTotalActualizar">
                        <input type="hidden" name="ofertaID" id="ofertaID">

                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Oferta</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group row">
                                <label for="precio" class="col-6 col-form-label">Precio</label>
                                <div class="col-6">
                                    <input id="precioActualizar" type="number"
                                           class="text-right form-control{{ $errors->has('precioActualizar') ? ' is-invalid' : '' }}"
                                           name="precioActualizar" value="{{ old('precioActualizar') }}" required
                                           autofocus onkeyup="actualizarPrecioTotal(this)"
                                           onkeypress='return event.charCode >= 48 && event.charCode <= 57'/>
                                    @if ($errors->has('precioActualizar'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('precioActualizar') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="comision" class="col-6 col-form-label">Comisión</label>
                                <div class="col-6">
                                    <p id="comision" class="col-form-label text-right mr-3">20%</p>
                                </div>
                            </div>
                            <hr/>
                            <div class="form-group row">
                                <label for="total" class="col-6 col-form-label">Total</label>
                                <div class="col-6">
                                    <p id="totalActualizar" class="col-form-label text-right mr-3">
                                        ${{number_format(0, 0, '.', ',')}}</p>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn themed-btn">Actualizar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!--oferta modal ELIMINAR-->
        <div class="modal fade" id="ofertaModalEliminar" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form id="eliminarPorpuestaForm" method="post"
                          action="{{route('eliminarPropuesta', ['solicitud' => $solicitud])}}" autocomplete="off">
                        @method('DELETE')
                        @csrf

                        <input type="hidden" name="ofertaIDEliminar" id="ofertaIDEliminar">

                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Confirmar eliminación</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p>¿Está seguro que desea eliminar su oferta?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-danger">Eliminar</button>
                            <button type="button" class="btn themed-btn" data-dismiss="modal" aria-label="Close">
                                Cancelar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


        <div class="solicitud-container d-flex floating-card bg-semi-transparent borde-blanco">
            <div class="d-inline-block">
                <div class="d-inline-block">
                    <h3>{{$solicitud->titulo}}</h3>
                </div>
                <div class="d-inline-block">
                    <a class="cursor-pointer" onclick="cargarUbicacion({{$solicitud}})" data-toggle="modal"
                       data-target="#mapModal">
                        <img class="client-icon d-inline-block" alt="lugar" src="{{asset('images/placeholder.png')}}">
                        <p class="d-inline-block">{{$solicitud->ciudad}}</p>
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
                                    {{$horario->hora_inicio->format('g:i A')}}
                                    - {{$horario->hora_fin->format('g:i A')}}</p>
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
                <div class="user-info-horizontal mt-3 mb-3 mb-md-1">
                    <a class="client-icon"
                       href="{{route('visitarPerfil', ['user'=> $solicitud->cliente->usuario->slug])}}">
                        <img class="rounded-circle" width="100%" height="100%" alt="user"
                             src="{{asset('images/avatars/'.$solicitud->cliente->usuario->foto)}}">
                    </a>
                    <p>{{$solicitud->cliente->usuario->nombre}}</p>
                    <div class="rating-container">
                        <img id="emptyRating" alt="rating" src="{{asset('images/empty_rating.png')}}">
                        <div class="fullRating-container"
                             style="min-width: calc(64px*{{$solicitud->cliente->usuario->ratingPorcentage()}}); max-width: calc(100px*{{$solicitud->cliente->usuario->ratingPorcentage()}}); width: calc(10vw*{{$solicitud->cliente->usuario->ratingPorcentage()}});"></div>
                    </div>
                </div>
                <button type="button" class="crear-propuesta btn apply-sm d-block d-md-none bg-base" data-toggle="modal"
                        data-target="#ofertModal">Crear propuesta
                </button>
            </div>
            <button type="button" class="crear-propuesta btn apply-lg d-none d-md-block ml-auto bg-base"
                    data-toggle="modal" data-target="#ofertModal">Crear propuesta
            </button>
        </div>

        <div class="propuestas">
            <div class="propuestas-header bg-dark floating-card">
                <h4>Propuestas</h4>
            </div>

            @if($solicitud->ofrecimientos->isEmpty())
                <div class="margenes-normales floating-card bg-semi-transparent">
                    <p class="d-inline-block">Aún no hay propuestas de otros entrenadores. Aprovecha y se el primero en
                        crear una!</p>
                </div>
            @endif

            @foreach($solicitud->ofrecimientos as $ofrecimiento)
                <div class="offer-container floating-card bg-grey">
                    <div class="float-left">
                        <a href="{{route('visitarPerfil', ['user'=> $ofrecimiento->entrenador->slug])}}">
                            <img class="rounded-circle vw-100 vh-100 max-w-100 max-h-100 min-w-60 min-h-60" alt="user"
                                 src="{{asset('images/avatars/'.$ofrecimiento->entrenador->foto)}}">
                        </a>
                    </div>
                    <div class="user-info d-inline-block">
                        <h4>{{$ofrecimiento->entrenador->nombre}}</h4>
                        <div class="fullRating-container-solicitud"
                             style="min-width: calc(64px*{{$ofrecimiento->entrenador->ratingPorcentage()}}); max-width: calc(100px*{{$ofrecimiento->entrenador->ratingPorcentage()}}); width: calc(10vw*{{$ofrecimiento->entrenador->ratingPorcentage()}});"></div>
                        <img id="emptyRating-solicitud" alt="rating" src="{{asset('images/empty_rating.png')}}">
                        <p class="grey">{{$ofrecimiento->entrenador->reviews->count()}} reviews</p>
                        <img class="ranking-solicitud" alt="ranking" src="{{asset('images/ranking.jpg')}}">
                        <!--TODO replace for real image depending on trainer level-->
                    </div>
                    <div class="trainer-description d-none d-md-inline-block">
                        <p class="d-lg-none d-inline-block">
                            <small>{{$ofrecimiento->entrenador->descripcion}}</small>
                        </p>
                        <p class="d-none d-lg-inline-block">{{$ofrecimiento->entrenador->descripcion}}</p>
                    </div>
                    <div class="price-container float-right">
                        <h4>{{number_format($ofrecimiento->precio, 0, '.', ',')}}</h4>
                        <h4 class="mb-3">COP</h4>
                        @if($ofrecimiento->entrenador->id == $usuario)
                            <div class="d-none d-md-block mt-auto">
                                @if($ofrecimiento->estado == 2)
                                    <!--de solicitud modificada-->
                                    <div class="d-inline-block">
                                        <form id="confirmarPropuestaForm" method="POST"
                                              action="{{route('confirmarPropuesta')}}" autocomplete="off">
                                            <input type="hidden" name="ofertaIDConfirmar" id="ofertaIDConfirmar"
                                                   value="{{$ofrecimiento->id}}">
                                            @method('PUT')
                                            @csrf
                                            <button type="submit" class="btn bg-success fas fa-check"
                                                    style="min-width: unset; color: white;"></button>
                                        </form>
                                    </div>
                                @endif
                                <button type="button" data-ofertaid="{{$ofrecimiento->id}}" data-toggle="modal"
                                        data-target="#ofertaModalActualizar" class="btn bg-third fas fa-pencil-alt"
                                        style="min-width: unset;"></button>
                                <button type="button" data-ofertaid="{{$ofrecimiento->id}}" data-toggle="modal"
                                        data-target="#ofertaModalEliminar" class="btn bg-danger fa fa-trash"
                                        style="min-width: unset;"></button>
                            </div>
                        @endif
                    </div>
                    <div style="height: 1px; clear:both;"></div>
                    @if($ofrecimiento->entrenador->id == $usuario)
                        @if($ofrecimiento->estado == 2)
                            <!--de solicitud modificada-->
                            <div class="mb-1 d-md-none">
                                <form id="confirmarPropuestaForm" method="POST" action="{{route('confirmarPropuesta')}}"
                                      autocomplete="off">
                                    <input type="hidden" name="ofertaIDConfirmar" id="ofertaIDConfirmar"
                                           value="{{$ofrecimiento->id}}">
                                    @method('PUT')
                                    @csrf
                                    <button type="submit" class="btn bg-success fas fa-check"
                                            style="min-width: unset; color: white; width: 100%"></button>
                                </form>
                            </div>
                        @endif
                        <div class="d-flex d-md-none" style="justify-content: space-between">
                            <button type="button" data-ofertaid="{{$ofrecimiento->id}}" data-toggle="modal"
                                    data-target="#ofertaModalActualizar" class="btn bg-third fas fa-pencil-alt mr-2"
                                    style="width: -webkit-fill-available;"></button>
                            <button type="button" data-ofertaid="{{$ofrecimiento->id}}" data-toggle="modal"
                                    data-target="#ofertaModalEliminar" class="btn bg-danger fa fa-trash"
                                    style="width: -webkit-fill-available"></button>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>

    </div>

    @if(Session::has('errors'))
        <script>
            $(document).ready(function () {
                $('#ofertModal').modal({show: true});
            });
        </script>
    @endif

    <!--Asignar id de la oferta a editar-->
    <script>
        $('#ofertaModalActualizar').on('shown.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            document.getElementById('ofertaID').value = button.data('ofertaid');
        });
    </script>

    <!--Asignar id de la oferta a eliminar-->
    <script>
        $('#ofertaModalEliminar').on('shown.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            document.getElementById('ofertaIDEliminar').value = button.data('ofertaid');
        });
    </script>


    <!--Mostrar crear propuesta-->
    <script>
        var ofrecimientos = {!! $solicitud->ofrecimientos !!};
        var usuario = '<?php echo $usuario ?>';
        ofrecimientos.forEach(function (ofrecimiento) {
            if (ofrecimiento['usuario_id'] == usuario) {
                $('.crear-propuesta').removeClass('d-block');
                $('.crear-propuesta').removeClass('d-md-block');
                $('.crear-propuesta').hide();

                return;
            }
        })
    </script>

    <!--precio-->
    <script>
        function actualizarPrecioTotal(input) {
            var precioTotal = document.getElementById('total');
            var precioTotalActualizar = document.getElementById('totalActualizar');
            var precioEntrenador = parseFloat(input.value) || 0;
            precioTotal.innerHTML = (precioEntrenador + (precioEntrenador * 0.20)).formatMoney(0, '.', ',');
            precioTotalActualizar.innerHTML = (precioEntrenador + (precioEntrenador * 0.20)).formatMoney(0, '.', ',');
            document.getElementById('precioTotal').value = precioEntrenador + (precioEntrenador * 0.20);
            document.getElementById('precioTotalActualizar').value = precioEntrenador + (precioEntrenador * 0.20);
        }

        Number.prototype.formatMoney = function (c, d, t) {
            var n = this,
                c = isNaN(c = Math.abs(c)) ? 2 : c,
                d = d == undefined ? "." : d,
                t = t == undefined ? "," : t,
                s = n < 0 ? "-" : "",
                i = String(parseInt(n = Math.abs(Number(n) || 0).toFixed(c))),
                j = (j = i.length) > 3 ? j % 3 : 0;
            return s + '$' + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
        };
    </script>

    <!--Maps-->
    <script>
        var map, infoWindow;
        var marker;
        var geocoder = new google.maps.Geocoder();

        function initMap() {
            map = new google.maps.Map(document.getElementById('map'), {
                center: {lat: -34.397, lng: 150.644},
                zoom: 15
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
                position: location,
                draggable: draggable,
                map: map
            });
        }
    </script>
    <script async defer
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDjn6uQjll2HhwGi8L5_QTs4bAxAjqh5E0&callback=initMap">
    </script>

@endsection
