@extends('layouts.app')
@section('title')
    Users
@endsection
@push('head-content')
    <style>
        td { cursor: pointer; }
    </style>
@endpush
@section('content')
    <div class="container">
        <h2>Listado de Usuarios</h2>

        <input type="number" name="phone" placeholder="Buscar por número de teléfono">
    </div>
    <div class="container">
        <h2>Listado de Usuarios</h2>
        <table class="table" data-color="white">
            <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Email</th>
                <th>Telefono</th>
            </tr>
            </thead>
            <tbody name="table">
            @foreach ($users as $user)
                <tr onclick="window.location='{{route('visitarPerfil', ['user'=>  $user->slug])}}';">
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->nombre }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->telefono }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{ $users->links() }}
    </div>
@endsection
@push('scripts')
    <script>
        $(document).ready(function () {
            $('input[name="phone"]').on('input', function () {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '/users/search',
                    method: 'GET',
                    data: {phone:  $(this).val()},
                    dataType: 'json',
                    success: function (data) {
                        // Limpiar la tabla
                        $('tbody[name="table"]').empty();
                        data.forEach(function (result) {
                            $('tbody[name="table"]').append(
                                '<tr onclick="window.location=\'{{env('APP_URL')}}/visitar/' + result.slug + '\';">' +
                                    '<td>' + result.id + '</td>' +
                                    '<td>' + result.nombre + '</td>' +
                                    '<td>' + result.email + '</td>' +
                                    '<td>' + result.telefono + '</td>' +
                                '</tr>'
                            );
                        });
                        $('.pagination').hide();
                    },
                    error: function (data) {
                        alert('Error filtering users')
                    }
                });
            });
        });
    </script>
@endpush
