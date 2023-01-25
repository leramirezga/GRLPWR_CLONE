@extends('layouts.app')

@section('title')
    Mis Solicitudes
@endsection

@section('head-content')
    <link rel="stylesheet" href="{{asset('css/solicitudServicio.css')}}">
@endsection

@section('content')

    <div class="container-fluid">

        <div class="sticky-top event-information-container floating-card bg-grey">
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

        @if($solicitud->ofrecimientos->isEmpty())
            <div class="margenes-normales floating-card bg-semi-transparent">
                <p class="d-inline-block">Parece que aún no tienes ofertas, los entrenadores están revisando tu
                    solicitud.</p>
            </div>
        @endif

        @foreach($solicitud->ofrecimientos as $ofrecimiento)
            <div class="offer-container floating-card bg-semi-transparent">
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
                    @if($ofrecimiento->estado == 2)
                        <!--de solicitud modificada-->
                        <button type="submit" class="btn apply-lg d-none d-md-block mt-auto bg-base" disabled>En espera
                            por <br/> modificacion
                        </button>
                    @else
                        <button type="submit" class="btn apply-lg d-none d-md-block mt-auto bg-base"
                                onclick="showPayModal({{$solicitud}}, {{Auth::user()}}, {{$ofrecimiento}})">Contratar
                        </button>
                    @endif
                    <!--TODO agregar la lógica del botón de contratar-->
                </div>
                <div style="height: 1px; clear:both;"></div>
                @if($ofrecimiento->estado == 2)
                    <!--de solicitud modificada-->
                    <button type="button" class="btn apply-sm d-block d-md-none bg-base" disabled>En espera por
                        modificacion
                    </button>
                @else
                    <button type="button" class="btn apply-sm d-block d-md-none bg-base"
                            onclick="showPayModal({{$solicitud}}, {{Auth::user()}}, {{$ofrecimiento}})">Contratar
                    </button>
                @endif
            </div>
        @endforeach
    </div>

    <script type="text/javascript" src="https://checkout.epayco.co/checkout.js"></script>

    <!--PAGO-->
    <script>
        var handler = ePayco.checkout.configure({
            key: '71c83236ba0231c2d3e4048be66fc298',
            test: true
        });
        var data = {
            //Parametros compra (obligatorio)
            name: "Servicio de entrenamiento",
            description: "Servicio de entrenamiento",
            invoice: "",
            currency: "cop",
            tax_base: "0",
            tax: "0",
            country: "co",
            lang: "es",

            //Onpage="false" - Standard="true"
            external: "false",

            //Atributos opcionales
            response: "https://intraining.com.co/response_pago",
        };

        function showPayModal(solicitud, cliente, oferta) {
            data.amount = oferta.precio;
            data.extra1 = solicitud.id;
            data.extra2 = oferta.id;
            //Atributos cliente
            data.type_doc_billing = "cc";
            data.mobilephone_billing = cliente.telefono;
            handler.open(data)
        }
    </script>
    <!--FIN PAGO-->

@endsection
