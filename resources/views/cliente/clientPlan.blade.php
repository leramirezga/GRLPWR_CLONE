<div class="{{\Illuminate\Support\Facades\Blade::check('feature', 'dark_theme', false) ? "floating-card bg-semi-transparent" : ""}} p-3 mb-3">
    <div>
        <h3>Mis planes:</h3>
    </div>

    @isset($clientPlans)
        @foreach($clientPlans as $clientPlan)
            <div class="solicitud-container  text-center text-md-left d-md-flex {{\Illuminate\Support\Facades\Blade::check('feature', 'dark_theme', false) ? "floating-card bg-semi-transparent" : "box-shadow"}} mb-3 mt-5">
                <div>
                    <h3 class="d-block my-2">{{$clientPlan->plan->name}}</h3>
                    <p class="d-block my-1"><strong>Clases Restantes:</strong></p>
                    @isset($clientPlan->sharedClasses)
                        <p class="d-inline-block">@foreach($clientPlan->sharedClasses as $class)
                                {{$class->classType->type}}
                                @if(!$loop->last)
                                    <span> o </span>
                                @endif
                            @endforeach
                        </p>
                        <p class="d-inline-block" style="margin-left: -4px">: {{$clientPlan->remaining_shared_classes}}</p>
                    @endisset

                    @isset($clientPlan->specificClasses)
                        @foreach($clientPlan->specificClasses as $class)
                            <p>{{$class->classType->type}}: {{$class->remaining_classes}}</p>
                        @endforeach
                    @endisset

                    @isset($clientPlan->unlimitedClasses)
                        @foreach($clientPlan->unlimitedClasses as $class)
                            <p>{{$class->classType->type}}: <span class="align-middle" style="font-size: x-large;">∞</span></p>
                        @endforeach
                    @endisset
                    <p class="d-block my-1"><strong>Válido hasta: </strong>{{$clientPlan->expiration_date}}</p>
                </div>
            </div>
        @endforeach
    @else
        <div class="text-center p-3 {{\Illuminate\Support\Facades\Blade::check('feature', 'dark_theme', false) ? "" : "box-shadow mt-4"}}">
            <p>Aún no tienes planes</p>
            <a href="{{route('plans')}}" class="">
                <button type="button" class="btn btn-success mt-2">Ver planes</button>
            </a>
        </div>
    @endisset
</div>