<div class="{{\Illuminate\Support\Facades\Blade::check('feature', 'dark_theme', false) ? "floating-card bg-semi-transparent" : ""}} p-3 mb-3">
    <div>
        <h3>Mis planes:</h3>
    </div>

    @if(isset($clientPlan))
        <div class="solicitud-container  text-center text-md-left d-md-flex {{\Illuminate\Support\Facades\Blade::check('feature', 'dark_theme', false) ? "floating-card bg-semi-transparent" : "box-shadow"}} mb-3 mt-5">
            <div>
                <h3 class="d-block my-2">{{$clientPlan->plan->name}}</h3>
                <p class="d-block my-1"><strong>Clases Restantes:</strong> {{$clientPlan->remaining_classes}}</p>
                <p class="d-block my-1"><strong>Válido hasta:</strong> {{$clientPlan->expiration_date}}</p>
            </div>
        </div>
    @else
        <div class="text-center p-3 {{\Illuminate\Support\Facades\Blade::check('feature', 'dark_theme', false) ? "" : "box-shadow mt-4"}}">
            <p>Aún no tienes planes</p>
            <a href="{{route('plans')}}" class="">
                <button type="button" class="btn btn-success mt-2">Ver planes</button>
            </a>
        </div>
    @endif
</div>