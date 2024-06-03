@extends('layouts.app')

@section('title')
    {{$event->nombre}}
@endsection

@section('content')
    <div class="text-center">
        @if(\Illuminate\Support\Facades\Auth::user()->hasRole(\App\Utils\RolsEnum::CLIENT) && \Illuminate\Support\Facades\Auth::user()->cliente == null)
            <h2 class="w-75 m-auto">Para agendarte a los eventos debes completar tu perfil</h2>
            <button class="btn themed-btn d-block mx-auto mt-3" data-toggle="modal"
                    data-target="#completarPerfilModal">Completar perfil
            </button>
        @else
            @if(strcasecmp($event->classType->type, \App\Utils\PlanTypesEnum::KANGOO->value) === 0 &&
                    (!\Illuminate\Support\Facades\Auth::user()->cliente->peso() || !\Illuminate\Support\Facades\Auth::user()->cliente->talla_zapato))
                <h2 class="w-75 m-auto">Para los eventos de kangoo debes completar tu perfil con la información de tu peso y talla de zapato</h2>
                <button class="btn themed-btn d-block mx-auto mt-3" data-toggle="modal"
                        data-target="#completarPerfilModal">Completar perfil
                </button>
            @else
                <div>
                    <h1 class="text-center mt-3 ">
                        {{$event->nombre}}
                    </h1>
                    <p class="text-center mb-1"><strong>{{Carbon\Carbon::parse($event->fecha_inicio)->translatedFormat('l d F', 'es')}} {{$event->start_hour}}</strong></p>
                    <p class="text-center mb-1">Lugar: {{$event->lugar}}</p>
                    <div class="w-75 m-auto d-flex justify-content-center">
                        <img class="exercise-image" src="{{asset('images/'.$event->imagen)}}"
                             alt="Eventos @lang('general.AppName')">
                    </div>
                    @if(\Illuminate\Support\Facades\Auth::user()->hasFeature(\App\Utils\FeaturesEnum::SEE_ATTENDEES))
                        @include('admin.attendeesTable')
                    @endif
                </div>
                <div class="d-flex flex-wrap col-lg-8 m-auto">
                    <div id="sesionInfo" class="mt-3 w-100 text-center">
                        <ul class="nav nav-tabs justify-content-around" id="infoTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link white-nav-link active" id="description-tab" data-toggle="tab"
                                   href="#description" role="tab" aria-controls="description" aria-selected="true">Descripción</a>
                            </li>
                        </ul>
                        <div class="tab-content w-100 w-md-75 m-3" id="infoTabContent" style="text-align: justify;">
                            <div class="tab-pane fade show active" id="description" role="tabpanel"
                                 aria-labelledby="description-tab">{{$event->descripcion}}</div>
                            <div class="tab-pane fade" id="additional-info" role="tabpanel"
                                 aria-labelledby="additional-info-tab">{{$event->info_adicional}}</div>
                        </div>
                        <div class="d-flex justify-content-around">
                            <button type="button" class="btn themed-btn ms-3" data-toggle="modal" data-target="#alertaCancelaciontemprana" >Agendar</button>
                            <button type="button" class="btn themed-btn ms-3" data-toggle="modal" data-target="#guestModal" >Invitar</button>
                        </div>
                    </div>
                </div>
                @if(\Illuminate\Support\Facades\Auth::user()->hasRole(\App\Utils\RolsEnum::CLIENT))
                    @include('scheduleModal')
                @endif
                <h2 class="text-center mt-5 ">
                    Próximos Eventos
                </h2>

                @include('proximasSesiones')
            @endif
        @endif
    </div>

    @include('components.modalCancelPolicy')
    @include('cliente.scheduleGuestModal')

    @if(\Illuminate\Support\Facades\Auth::user()->hasRole(\App\Utils\RolsEnum::CLIENT))
        @include('cliente.completeProfileClient')
        @include('modalCompletarPerfil')
    @endif
@endsection

@push('scripts')
    <!--PAYMENT-->
    <script type="text/javascript" src="https://checkout.epayco.co/checkout.js"></script>
    <script>
        document.getElementById("agendarForm").addEventListener("submit", submitListener, true);
        let rentEquipment = false;
        const requiresEquipment = {{$event->classType->required_equipment !== null ? 1 : 0}};

        function checkPlan() {
            if({{isset($plan) ? 1 : 0}}){
                scheduleEvent(requiresEquipment && {{isset($equipmentIncluded) && $equipmentIncluded ? 1 : 0}});
            }
            else{
                if({{$event->classType->required_equipment !== null ? 1 : 0}}){
                    var scheduleModal = new bootstrap.Modal(document.getElementById('scheduleModal'));
                    scheduleModal.show();
                }else{
                    scheduleEvent(false);
                }
            }
        }


        function submitListener(event) {
            rentEquipment = !!+document.querySelector('input[name="rentEquipment"]:checked').value;
            event.preventDefault();
            scheduleEvent(rentEquipment);
        }

        function scheduleEvent(rentEquipment){
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ route('scheduleEvent') }}",
                method: "POST",
                data: {clientId:{{\Illuminate\Support\Facades\Auth::id()}},
                    eventId: {{$event->id}},
                    startDate: "{{Carbon\Carbon::parse($event->fecha_inicio)->format('d-m-Y')}}",
                    startHour: "{{$event->start_hour}}",
                    endDate: "{{Carbon\Carbon::parse($event->fecha_fin)->format('d-m-Y')}}",
                    endHour: "{{$event->end_hour}}",
                    rentEquipment: rentEquipment},

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
                    //console.log(data); //if you want to debug you need to uncomment this line and comment reload
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
            data.amount = !requiresEquipment || (requiresEquipment && rentEquipment) ? {{$event->precio}} : {{$event->precio_sin_implementos ?? -1}};//The -1 is only to fix sintax. Because an event that requires equipment alway should hace precio_sin_implementos
            data.extra1 = '{{ \App\Utils\PayTypesEnum::Session }}';
            data.extra2 = {{ \Illuminate\Support\Facades\Auth::id() }};
            data.extra3 = {{$event->id }};
            data.extra4 = sesionClienteId;
            data.extra5 = '{{Carbon\Carbon::parse($event->fecha_inicio)->format('d-m-Y') . ' ' . $event->start_hour }}';
            data.extra6 = '{{Carbon\Carbon::parse($event->fecha_fin)->format('d-m-Y')  . ' ' . $event->end_hour }}';
            data.type_doc_billing = "cc";
            handler.open(data);
        }
    </script>
    <!--END PAYMENT-->
@endpush

