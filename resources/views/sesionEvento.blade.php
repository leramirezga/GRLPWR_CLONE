@extends('layouts.app')

@section('title')
    {{$sesionEvento->evento->nombre}}
@endsection

@section('content')
    <div class="text-center">
        @if(strcasecmp (\Illuminate\Support\Facades\Auth::user()->rol, 'cliente' ) == 0 && \Illuminate\Support\Facades\Auth::user()->cliente == null)
            <h2>Para agendarte a los eventos debes completar tu perfil</h2>
            <button class="btn btn-success d-block ml-auto mr-auto" data-toggle="modal"
                    data-target="#completarPerfilModal">Completar perfil
            </button>
        @else
            <div>
                <h1 class="text-center mt-3">
                    {{$sesionEvento->evento->nombre}}
                </h1>
                <p class="text-center mb-1"><strong>{{$sesionEvento->fecha_inicio->isoFormat('dddd D MMMM')}} {{$sesionEvento->fecha_inicio->format('g:i A')}}</strong></p>
                <p class="text-center mb-1">Lugar: {{$sesionEvento->lugar}}</p>
                <div class="w-75 m-auto d-flex justify-content-center">
                    <img src="{{asset('images/'.$sesionEvento->evento->imagen)}}" height="600px"
                         alt="Eventos @lang('general.AppName')">
                </div>
            </div>
            <div class="d-flex flex-wrap">
                <div id="sesionInfo" class="mt-3 w-100 text-center">
                    <ul class="nav nav-tabs justify-content-around" id="infoTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link white-nav-link active" id="description-tab" data-toggle="tab"
                               href="#description" role="tab" aria-controls="description" aria-selected="true">Descripción</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link white-nav-link" id="additional-info-tab" data-toggle="tab"
                               href="#additional-info" role="tab" aria-controls="additional-info"
                               aria-selected="false">Info Adicional</a>
                        </li>
                    </ul>
                    <div class="tab-content w-100 w-md-75 m-3" id="infoTabContent" style="text-align: justify;">
                        <div class="tab-pane fade show active" id="description" role="tabpanel"
                             aria-labelledby="description-tab">{{$sesionEvento->evento->descripcion}}</div>
                        <div class="tab-pane fade" id="additional-info" role="tabpanel"
                             aria-labelledby="additional-info-tab">{{$sesionEvento->evento->info_adicional}}</div>
                    </div>
                    <button type="button" class="btn bg-fifth ms-3" onclick="checkPlan()">Agendar</button>
                </div>
            </div>
            @include('scheduleModal')
            <h1 class="text-center mt-5">
                Próximos Eventos
            </h1>

            @include('proximasSesiones')
        @endif
    </div>

    @include('cliente.completeProfileClient')
    @include('modalCompletarPerfil')
@endsection

@push('scripts')
    <!--PAYMENT-->
    <script type="text/javascript" src="https://checkout.epayco.co/checkout.js"></script>
    <script>
        function checkPlan(){
            if({{isset($plan) ? 1 : 0}}){
                scheduleEvent({{(isset($plan) && \App\Utils\PlanTypesEnum::Kangoo_rent->value - $plan->plan->plan_type) == 0 ? 1 : 0}});
            }
            else{
                var scheduleModal = new bootstrap.Modal(document.getElementById('scheduleModal'));
                scheduleModal.show();
            }
        }
    </script>
    <script>
        document.getElementById("agendarForm").addEventListener("submit", submitListener, true);
        var rentKangoos = false
        function submitListener(event) {
            rentKangoos = document.querySelector('input[name="rentKangoos"]:checked').value;
            event.preventDefault();
            scheduleEvent(rentKangoos);
        }

        function scheduleEvent(rentKangoos){
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ route('scheduleEvent') }}",
                method: "POST",
                data: {clientId:{{\Illuminate\Support\Facades\Auth::id()}},
                    sesionEventoId: {{$sesionEvento->id}},
                    rentKangoos: rentKangoos},

                success: function (data) {
                    switch (data['status']){
                        case 'success':
                            $('html, body').animate({ scrollTop: 0 }, 0);
                            location.reload();
                            break;
                        case 'reserved':
                            showPayModal(data['sesionClienteId']);
                            break;
                        case 'goToPay':
                            showPayModal();
                            break;
                    }
                },
                error: function(data) {
                    //console.log(data); if you want to debug yo need to uncomment this line and comment reload
                    $('html, body').animate({ scrollTop: 0 }, 0);
                    location.reload();
                }
            });
        }
        var handler = ePayco.checkout.configure({
            key: "{{env('EPAYCO_PUBLIC_KEY')}}",
            test: Boolean({{env('EPAYCO_TEST')}})
        });
        var data = {
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

        function showPayModal(sesionClienteId = null) {
            data.currency = '{{\Illuminate\Support\Facades\Session::get('currency_id') ? \Illuminate\Support\Facades\Session::get('currency_id') : 'COP'}}';
            data.amount = rentKangoos==true ? {{$sesionEvento->precio}} : {{$sesionEvento->precio - $sesionEvento->descuento}}
            data.extra1 = '{{ \App\Utils\PayTypesEnum::Session }}'
            data.extra2 = {{ \Illuminate\Support\Facades\Auth::id() }}
            data.extra3 = {{$sesionEvento->id }}
            data.extra4 = sesionClienteId;
            data.type_doc_billing = "cc";
            handler.open(data)
        }
    </script>
    <!--END PAYMENT-->
@endpush

