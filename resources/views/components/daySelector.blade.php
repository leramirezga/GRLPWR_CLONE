<div class="d-flex text-center" style="height: 80px}}">
    @foreach (range(0, 6) as $day)
        @php
            $date = \Carbon\Carbon::today()->addDays($day);
        @endphp
        <div class="daySelector themed-border clickable @if(!$loop->last) border-right-0  @endif p-2 flex-grow-1" data-date="{{$date}}" onclick="onSelectDate(this)">
            <p>{{$date->translatedFormat('D')}}</p>
            <h3>{{$date->day}}</h3>
        </div>
    @endforeach
</div>

@push('scripts')
    <script>

    </script>
@endpush