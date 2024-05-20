@push('head-content')
    <link href="{{asset('css/achievements.css')}}" rel="stylesheet"/>
@endpush
<h3 class="section-title mt-4">Logros:</h3>
<div class="col-12 col-md-10 mx-auto">
    <div class="d-flex justify-content-around">
        <div class="achievement-container themed-block mt-4 p-2 text-center">
            <div class="d-flex flex-column">
                <div class="position-relative m-auto" style="width: fit-content">
                @if($weeksStreak && $weeksStreak->points > 0)
                    <span class="achievement-badge theme-inverted">{{$weeksStreak->points}}{{$recordWeeksStreak ? '/'.$recordWeeksStreak->points : ''}}</span>
                    <img class="achievement-icon" src="{{asset('images/achievements/streak_color.png')}}"/>
                @else
                    <span class="achievement-badge bg-locked">{{$recordWeeksStreak?->points}}</span>
                    <img class="achievement-icon" src="{{asset('images/achievements/streak_grey.png')}}"/>
                @endif
                </div>
                <p class="small">Semanas Entrenadas</p>
            </div>
        </div>
    </div>
</div>
