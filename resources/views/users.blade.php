@extends('layouts.app')
@section('title')
    Users
@endsection
@section('content')
    <div class="container">
        <p>Buscar usuario</p>

        <input type="number" name="phone" placeholder="Buscar por número de teléfono">
    </div>
    <div class="container">
        <h2>Listado de Usuarios</h2>
        <table class="table">
            <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Email</th>
                <th>Telefono</th>
                <th>Acciones</th>
            </tr>
            </thead>
            <tbody name="table">
            @foreach ($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td><a class="client-icon theme-color" href="{{route('visitarPerfil', ['user'=>  $user->slug])}}"><div style="max-height:3rem; overflow:hidden">{{ $user->nombre . ' ' .  $user->apellido_1 . ' ' .  $user->apellido_2}}</div></a></td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->telefono }}</td>
                    <td><a class="client-icon theme-color" href="{{route('healthTest', ['user'=>  $user->slug])}}">Valoración</a></td>
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
                                '<tr>' +
                                    '<td>' + result.id + '</td>' +
                                    '<td><a class="client-icon theme-color" href="{{env('APP_URL')}}/visitar/' + result.slug +'"><div style="max-height:3rem; overflow:hidden">' + result.nombre + '</div></a></td>' +
                                    '<td>' + result.email + '</td>' +
                                    '<td>' + result.telefono + '</td>' +
                                    '<td><a class="client-icon theme-color" href="/user/' + result.slug +'/wellBeingTest">Valoración</a></td>' +
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
