@extends('estadisticasTemplate')

@section('contador2')
    <div class="contador-container">
        <div class="numero-contador-container">
            <h2 class="counter-count">{{$user->blogs()->count()}}</h2>
        </div>
        <h4>BLOGS</h4>
    </div>
@endsection
