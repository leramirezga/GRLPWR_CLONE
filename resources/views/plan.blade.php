@extends('layouts.app')

@section('title')
    {{$plan->name}}
@endsection

@section('content')
    <div class="text-center w-75 m-auto">
        <h1 class="text-center my-5">
            {{$plan->name}}sada
        </h1>
        @isset($plan->description)
            <p class="mb-4"> {{$plan->description}}</p>
        @endisset
        <h4><strong>Numero de clases: </strong>{{$plan->number_of_shared_classes}}</h4>
        <h4><strong>Precio: </strong> ${{number_format($plan->price, 0, '.', ',')}}</h4>
        @isset($plan->available_plans)
            <p><strong>Planes disponibles: </strong>{{$plan->available_plans}}</p>
        @endisset
        @isset($plan->expiration_date)
            <p><strong>Valido hasta: </strong>{{$plan->expiration_date}}</p>
        @endisset
        <button type="button" class="btn bg-fifth mt-4" onclick="showPayModal()">Adquirir</button>
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

        function showPayModal() {
            data.currency = '{{\Illuminate\Support\Facades\Session::get('currency_id') ? \Illuminate\Support\Facades\Session::get('currency_id') : 'COP'}}';
            data.amount ={{$plan->price}}
            data.extra1 = '{{ \App\Utils\PayTypesEnum::Plan }}'
            data.extra2 = {{ \Illuminate\Support\Facades\Auth::id() }}
            data.extra3 = {{ $plan->id }}
            data.type_doc_billing = "cc";
            handler.open(data)
        }
    </script>
    <!--END PAYMENT-->
@endpush

