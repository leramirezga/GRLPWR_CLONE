@include('components.daySelector')
<br>
@include('components.classTypeSelector', ['showAll' => true])

<div>
    @foreach($events as $event)
        <div class-type="{{ $event->class_type_id }}" day="{{$event->fecha_inicio}}" class="next-session solicitud-container text-center text-md-left themed-block mb-3 border-type-{{$event->class_type_id }}">
            <div class="d-md-flex">
                <div>
                    <h3 class="d-block my-2">{{$event->nombre}} </h3>
                    <p class="d-block my-1"><strong>Día:</strong> {{Carbon\Carbon::parse($event->fecha_inicio)->translatedFormat('l d F', 'es')}}</p>
                    <p class="d-block my-1"><strong>Hora:</strong> {{Carbon\Carbon::parse($event->start_hour)->translatedFormat('H:i')}} - {{Carbon\Carbon::parse($event->end_hour)->translatedFormat('H:i')}}</p>
                    <p class="d-block my-1"><strong>Lugar: </strong>{{$event->lugar}}</p>
                    <div class="d-block my-1">
                        <i class="material-icons align-middle">diversity_3</i>
                        <p class="d-inline-block">
                            {{$event->attendees->count()}} / {{$event->cupos}}
                        </p>
                    </div>
                </div>
                <div class="ml-auto my-3">
                    <a type="button" class="btn themed-btn" href="{{route('eventos.show',['event' => $event, 'date' => Carbon\Carbon::parse($event->fecha_inicio)->format('d-m-Y'), 'hour' => $event->start_hour, 'isEdited' => $event->getTable()=='edited_events' ? 1 : 0])}}">Ver mas</a>
                </div>
            </div>
        </div>
    @endforeach
</div>

@push('scripts')
    <script>
        var selectedDate = null;
        var filterType = "all"
        function onSelectDate(selected) {
            selected = $(selected);
            if(!selected.hasClass('selected')) {
                $('.daySelector').removeClass('selected');
                $(".next-session").fadeOut();
                selectedDate = selected.data('date');
                if (filterType === 'all') {
                    $('.next-session[day="' + selectedDate + '"]').fadeIn("3000");
                }else{
                    $('.next-session[class-type="' + filterType + '"][day="' + selectedDate + '"]').fadeIn("3000");
                }
                selected.addClass('selected')
            }
        }
        $(document).ready(function () {
            $('#classTypeSelector').on('change', function () {
                $(".next-session").fadeOut();
                filterType = $(this).val();
                if (filterType === 'all') {
                    if(selectedDate){
                        $('.next-session[day="' + selectedDate + '"]').fadeIn("3000");
                    }else{
                        $('.next-session').fadeIn("3000");
                    }
                }else{
                    if(selectedDate){
                        $('.next-session[class-type="' + filterType + '"][day="' + selectedDate + '"]').fadeIn("3000");
                    }else{
                        $('.next-session[class-type="' + filterType + '"]').fadeIn("3000");
                    }
                }
            });
        });
    </script>
@endpush
