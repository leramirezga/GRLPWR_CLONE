<div class="py-3 mb-3">
    <div>
        <h3>Mis planes:</h3>
    </div>
    @if($clientPlans and $clientPlans->isNotEmpty())
        @foreach($clientPlans as $clientPlan)
            <div class="solicitud-container  text-center text-md-left d-md-flex themed-block col-12 col-md-10 mx-auto mb-3 mt-5">
                <div>
                    <h3 class="d-block my-2">{{$clientPlan->plan->name}}</h3>
                    @if($clientPlan->remaining_shared_classes)
                        <p class="d-block my-1"><strong>Clases Restantes: </strong>{{$clientPlan->remaining_shared_classes}}</p>
                    @endif
                    {{-- FIT-57: Uncomment this if you want specific classes--}}
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
                    {{--FIT-57: end block code--}}
                    <p class="d-block my-1"><strong>Válido hasta: </strong>{{$clientPlan->expiration_date}}</p>
                </div>
            </div>
        @endforeach
    @else
        <div class="text-center p-3 col-12 col-md-10 themed-block mx-auto mt-3">
            <p>Aún no tienes planes</p>
            <a href="{{route('plans')}}" class="">
                <button type="button" class="btn themed-btn mt-2">Ver planes</button>
            </a>
        </div>
    @endisset
</div>