@extends('layouts.app')

@section('title')
    @lang('general.Plans')
@endsection

@section('content')
    <div class="d-md-flex justify-content-between justify-content-md-around w-75 m-auto flex-wrap">
        @foreach($plans as $plan)
            @if(\Illuminate\Support\Facades\Auth::user()->hasFeature(\App\Utils\FeaturesEnum::SEE_PAYMENT_METHODS))
            @if($plan->available_plans === null || $plan->available_plans > 0)
                @include('planCard')
            @endif
        @endforeach
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

        function showPayModal(plan) {
            data.currency = '{{\Illuminate\Support\Facades\Session::get('currency_id') ? \Illuminate\Support\Facades\Session::get('currency_id') : 'COP'}}';
            data.amount = plan.price
                data.extra1 = '{{ \App\Utils\PayTypesEnum::Plan }}'
            data.extra2 = {{ \Illuminate\Support\Facades\Auth::id() }}
                data.extra3 = plan.id
                data.type_doc_billing = "cc";
            handler.open(data)
        }
    </script>
    <!--END PAYMENT-->
@endpush

