@extends('cliente.clienteTemplate')

@section('title')
    {{$sesionEvento->evento->nombre}}
@endsection

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css"/>
@endpush


@section('content')
    <div class="container-fluid w-100">
        <div style="height: 70vh">
            <h1 class="text-center mt-3">
                {{$sesionEvento->evento->nombre}}
            </h1>
            <div class="h-75 w-75 m-auto">
                <img src="{{asset($sesionEvento->evento->imagen)}}" class="h-100 w-100 d-none d-lg-block " alt="Eventos Atraparte">
                <img src="{{asset($sesionEvento->evento->imagen)}}" class="h-100 w-100 d-block d-lg-none" alt="Eventos Atraparte">
            </div>

        </div>
        <!-- Second page events 2 -->
        <form id="agendarForm" autocomplete="off">
            @csrf
            <div class="d-flex flex-wrap">
                <div id="sesionInfo" class="mt-3 w-100 text-center">
                    <ul class="nav nav-tabs justify-content-around" id="infoTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link white-nav-link active" id="description-tab" data-toggle="tab" href="#description" role="tab" aria-controls="description" aria-selected="true">Descripción</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link white-nav-link" id="additional-info-tab" data-toggle="tab" href="#additional-info" role="tab" aria-controls="additional-info" aria-selected="false">Info Adicional</a>
                        </li>
                    </ul>
                    <div class="tab-content w-100 w-md-75 m-3" id="infoTabContent" style="text-align: justify;">
                        <div class="tab-pane fade show active" id="description" role="tabpanel" aria-labelledby="description-tab">{{$sesionEvento->evento->descripcion}}</div>
                        <div class="tab-pane fade" id="additional-info" role="tabpanel" aria-labelledby="additional-info-tab">{{$sesionEvento->evento->info_adicional}}</div>
                    </div>
                    <button type="submit" class="btn bg-fifth ms-3">Agendar</button>
                </div>
            </div>
        </form>
        <h1 class="text-center mt-3">
            Otros Eventos
        </h1>

        <!-- Event calendar -->
        <div id='calendar'></div>
    </div>
@endsection

@push('scripts')
    <!--PAYMENT-->
    <script type="text/javascript" src="https://checkout.epayco.co/checkout.js"></script>
    <script>
        var handler = ePayco.checkout.configure({
            key: "{{env('EPAYCO_PUBLIC_KEY')}}",
            test: Boolean({{env('EPAYCO_TEST')}})
        });
        var data={
            //Parametros compra (obligatorio)
            name: "{{__('general.transaction_name')}}",
            description: "{{__('general.transaction_name')}}",
            invoice: "",
            tax_base: "0",
            tax: "0",
            country: "co",
            lang: "es",

            //Onpage="false" - Standard="true"
            external: "false",

            //Atributos opcionales
            response: "{{config('app.url')}}/response_payment",
        };

        document.getElementById("agendarForm").addEventListener("submit", showPayModal, true);

        function showPayModal(event) {
            event.preventDefault();
            data.currency= '{{\Illuminate\Support\Facades\Session::get('currency_id') ? \Illuminate\Support\Facades\Session::get('currency_id') : 'COP'}}';
            data.amount = {{$sesionEvento->precio}}
            data.extra1= {{$sesionEvento->id }}
            data.extra2 = {{ \Illuminate\Support\Facades\Auth::id() }}
            data.type_doc_billing= "cc";
            handler.open(data)
        }
    </script>
    <!--PAYMENT-->
    <script>
        $(document).ready(function () {
            var SITEURL = "{{env('APP_URL')}}";

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var calendar = $('#calendar').fullCalendar({
                height: 400,
                editable: true,
                events: SITEURL + "/events",
                displayEventTime: true,
                eventRender: function (event, element, view) {
                    if (event.allDay === 'true') {
                        event.allDay = true;
                    } else {
                        event.allDay = false;
                    }
                }, eventColor: '#378006',
            });
        });

        function displayMessage(message) {
            toastr.success(message, 'Event');
        }

    </script>

    <!--DONT CHANGE THE ORDER-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
@endpush

