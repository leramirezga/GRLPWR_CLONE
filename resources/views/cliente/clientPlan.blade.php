<div class="{{\Illuminate\Support\Facades\Blade::check('feature', 'dark_theme', false) ? "floating-card bg-semi-transparent" : ""}} p-3 mb-3">
    <div>
        <h3>Mis planes:</h3>
    </div>
    @if($clientPlans and $clientPlans->isNotEmpty())
        @foreach($clientPlans as $clientPlan)
            <div class="solicitud-container  text-center text-md-left d-md-flex {{\Illuminate\Support\Facades\Blade::check('feature', 'dark_theme', false) ? "floating-card bg-semi-transparent" : "box-shadow"}} mb-3 mt-5">
                <div>
                    <h3 class="d-block my-2">{{$clientPlan->plan->name}}</h3>
                    @if($clientPlan->remaining_shared_classes)
                        <p class="d-block my-1"><strong>Clases Restantes: </strong>{{$clientPlan->remaining_shared_classes}}</p>
                    @endif
                    {{-- FIT-57: Uncomment this if you want specific classes
                    @if($clientPlan->sharedClasses && !$clientPlan->sharedClasses->isEmpty())
                        <p class="d-inline-block">@foreach($clientPlan->sharedClasses as $class)
                                {{$class->classType->type}}
                                @if(!$loop->last)
                                    <span> o </span>
                                @endif
                            @endforeach
                        </p>
                        <p class="d-inline-block" style="margin-left: -4px">: {{$clientPlan->remaining_shared_classes}}</p>
                    @endif

                    @if($clientPlan->specificClasses && !$clientPlan->specificClasses->isEmpty())
                        @foreach($clientPlan->specificClasses as $class)
                            <p>{{$class->classType->type}}: {{$class->remaining_classes}}</p>
                        @endforeach
                    @endif

                    @if($clientPlan->unlimitedClasses && !$clientPlan->unlimitedClasses->isEmpty())
                        <p class="d-inline-block">@foreach($clientPlan->unlimitedClasses as $class)
                                {{$class->classType->type}}
                                @if(!$loop->last)
                                    <span>, </span>
                                @endif
                            @endforeach
                        </p>
                        <p class="d-inline-block" style="margin-left: -4px">: ∞</p>
                    @endif
                    --}}
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