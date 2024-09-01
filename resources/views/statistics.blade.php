@extends('layouts.app')
@php
    $statisticsFeature = \DB::table('features')->where('title', 'SEE_STATISTICS')->whereNotNull('active_at')->first();
@endphp
@if($statisticsFeature)
    @section('title')
        Users
    @endsection

    @section('content')
        <div class="container">
            @include('components.historicActiveClients')
        </div>
    @endsection
@endif

