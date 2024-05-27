<!-- resources/views/cliente/weekachievements.blade.php -->

@extends('layouts.app')

@section('title', 'Ranking semanas completadas')

@section('content')

    <link rel="stylesheet" href="{{ asset('css/ranking.css') }}">
    <h1>Ranking semanas completadas</h1>
    <div class="table-container">
        <table class="week-achievements-table">
            <thead>
            <tr>
                <th>Girly</th>
                <th>Semanas seguidas completadas</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($achievements as $achievement)
                <tr>
                    <td>{{ $achievement->achiever->nombre }}</td>
                    <td>{{ $achievement->points }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
