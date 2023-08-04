@foreach($events as $event)
    <div class="solicitud-container  text-center text-md-left d-md-flex {{\Illuminate\Support\Facades\Blade::check('feature', 'dark_theme', false) ? "floating-card bg-semi-transparent" : "box-shadow"}} mb-3">
        <div>
            <h3 class="d-block my-2">{{$event->nombre}} </h3>
            <p class="d-block my-1"><strong>Día:</strong> {{Carbon\Carbon::parse($event->fecha_inicio)->translatedFormat('l d F', 'es')}}</p>
            <p class="d-block my-1"><strong>Hora:</strong> {{$event->start_hour}}</p>
            <p class="d-block my-1"><strong>Lugar: </strong>{{$event->lugar}}</p>
            @if((strcasecmp (\Illuminate\Support\Facades\Auth::user()->rol, \App\Utils\Constantes::ROL_ADMIN ) == 0))
                <p class="d-block my-1"><strong>Asistentes: </strong>{{$event->attendees->count()}}</p>
            @endif
        </div>
        <div class="ml-auto my-3">

            <a type="button" class="btn btn-success" href="{{route('eventos.show',['evento' => $event, 'date' => Carbon\Carbon::parse($event->fecha_inicio)->format('d-m-Y'), 'hour' => $event->start_hour])}}">Ver mas</a>
        </div>
    </div>
@endforeach
