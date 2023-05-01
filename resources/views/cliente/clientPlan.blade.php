<div class="floating-card bg-semi-transparent p-3 mb-3">
    <div>
        <h3>Mis planes:</h3>
    </div>

    @if(isset($clientPlan))
        <div class="solicitud-container  text-center text-md-left d-md-flex floating-card bg-semi-transparent mb-3 mt-5">
            <div>
                <h3 class="d-block my-2">{{$clientPlan->plan->name}}</h3>
                <p class="d-block my-1"><strong>Clases Restantes:</strong> {{$clientPlan->remaining_classes}}</p>
            </div>
        </div>
    @else
        <div class="text-center">
            <p class="my-3">Aún no tienes planes</p>
            <a href="{{route('plans')}}" class="my-1">
                <button type="button" class="btn btn-success">Ver planes</button>
            </a>
        </div>
    @endif
</div>