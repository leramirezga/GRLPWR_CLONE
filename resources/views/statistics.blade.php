@extends('layouts.app')
@if(\Illuminate\Support\Facades\Auth::user()->hasFeature(\App\Utils\FeaturesEnum::SEE_STATISTICS))
    @section('title')
        Users
    @endsection

    @section('content')
        <div class="container">
            @include('components.historicActiveClients')
        </div>
    @endsection
    @endif

