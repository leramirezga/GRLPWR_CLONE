@include('components.classTypeSelector', ['showAll' => true])

<div id="functional" class="d-none">
    <div class="hourSelector">
        <div class="input-group">
            <span class="iconos">
                <i class="material-icons">calendar_today</i>
            </span>
            <div class="form-group label-floating">
                <label class="control-label">Día <small>(requerido)</small></label>
                <select class="form-control pl-1" id="hourSelector" name="event">
                    <option value="Monday" selected>Lunes</option>
                    <option value="Tuesday" selected>Martes</option>
                    <option value="Wednesday" selected>Miercoles</option>
                    <option value="Thursday" selected>Jueves</option>
                    <option value="Friday" selected>Viernes</option>
                </select>
            </div>
        </div>
    </div>
</div>
<div id="non-functional">
    @foreach($events as $event)
        <div class-type="{{ $event->class_type_id }}" day="{{$event->day}}" class="next-session solicitud-container text-center text-md-left d-md-flex {{\Illuminate\Support\Facades\Blade::check('feature', 'dark_theme', false) ? "floating-card bg-semi-transparent" : "box-shadow"}} mb-3">
            <div>
                <h3 class="d-block my-2">{{$event->nombre}} </h3>
                <p class="d-block my-1"><strong>Día:</strong> {{Carbon\Carbon::parse($event->fecha_inicio)->translatedFormat('l d F', 'es')}}</p>
                <p class="d-block my-1"><strong>Hora:</strong> {{Carbon\Carbon::parse($event->start_hour)->translatedFormat('H:i')}} - {{Carbon\Carbon::parse($event->end_hour)->translatedFormat('H:i')}}</p>
                <p class="d-block my-1"><strong>Lugar: </strong>{{$event->lugar}}</p>
                @if((strcasecmp (\Illuminate\Support\Facades\Auth::user()->rol, \App\Utils\Constantes::ROL_ADMIN ) == 0))
                    <p class="d-block my-1"><strong>Asistentes: </strong>{{$event->attendees->count()}}</p>
                @endif
            </div>
            <div class="ml-auto my-3">
                <a type="button" class="btn btn-success" href="{{route('eventos.show',['event' => $event, 'date' => Carbon\Carbon::parse($event->fecha_inicio)->format('d-m-Y'), 'hour' => $event->start_hour, 'isEdited' => $event->getTable()=='edited_events' ? 1 : 0])}}">Ver mas</a>
            </div>
        </div>
    @endforeach
</div>

@push('scripts')
    <script>
        $(document).ready(function () {
            var filterType = "all"
            $('#classTypeSelector').on('change', function () {
                filterType = $(this).val();
                $(".next-session").removeClass("d-md-flex").addClass("d-none");
                if(filterType == 2)
                {
                    $("#functional").removeClass("d-none").addClass("d-md-flex");
                }else{
                    $("#functional").removeClass("d-md-flex").addClass("d-none");
                    if (filterType === 'all') {
                        $(".next-session").removeClass("d-none").addClass("d-md-flex");
                    } else {
                        $('.next-session[class-type="' + filterType + '"]').removeClass("d-none").addClass("d-md-flex");
                    }
                }
            });
            $('#hourSelector').on('change', function () {
                var filterHour = $(this).val();
                $(".next-session").removeClass("d-md-flex").addClass("d-none");
                $('.next-session[class-type="' + filterType + '"][day="' + filterHour + '"]').removeClass("d-none").addClass("d-md-flex");
            });
        });
    </script>
@endpush
