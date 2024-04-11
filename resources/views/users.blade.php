@extends('layouts.app')
@section('title')
    Users
@endsection
@section('content')
    <div class="container" style="overflow-x: scroll;">
        <div class="d-flex">
            <h2>Listado de Usuarios</h2>
            <div class="form-check m-auto">
                <input class="form-check-input" type="checkbox" name="activeClients" id="activeClients">
                <label class="form-check-label terms-label" for="activeClients">
                   Clientes Activos
                </label>
            </div>
        </div>
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
                <tr>
                    <td><input type="number" id="id" name="id" placeholder="Id" ></td>
                    <td><input type="text" id="name" name="name" placeholder="Nombre"></td>
                    <td><input type="text" id="email" name="email" placeholder="Correo"></td>
                    <td><input type="number" id="phone" name="phone" placeholder="Celular"></td>
                    <td>
                        <div class="form-check m-auto">
                            <input class="form-check-input" type="checkbox" name="needAssessment" id="needAssessment">
                            <label class="form-check-label terms-label" for="needAssessment">
                                Val. pendiente
                            </label>
                        </div>
                    </td>
                </tr>
            @foreach ($users as $user)
                <tr class="user-row">
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
        $(document).ready(function() {

            function filter(){
                var idValue = $('#id').val();
                var nameValue = $('#name').val();
                var emailValue = $('#email').val();
                var phoneValue = $('#phone').val();
                var needAssessmentValue = $('#needAssessment').prop('checked');
                var activeClientsValue = $('#activeClients').prop('checked');

                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '/users/search',
                    method: 'GET',
                    data: {
                        id: idValue,
                        name: nameValue,
                        email: emailValue,
                        phone: phoneValue,
                        needAssessment : needAssessmentValue,
                        activeClients : activeClientsValue,
                    },
                    dataType: 'json',
                    success: function(data) {
                        // Limpiar la tabla
                        $('tbody[name="table"] .user-row').remove();
                        data.forEach(function(result) {
                            $('tbody[name="table"]').append(
                                '<tr class="user-row">' +
                                '<td>' + result.id + '</td>' +
                                '<td><a class="client-icon theme-color" href="{{env('APP_URL')}}/visitar/' + result.slug + '"><div style="max-height:3rem; overflow:hidden">' + result.nombre + '</div></a></td>' +
                                '<td>' + result.email + '</td>' +
                                '<td>' + result.telefono + '</td>' +
                                '<td><a class="client-icon theme-color" href="/user/' + result.slug + '/wellBeingTest">Valoración</a></td>' +
                                '</tr>'
                            );
                        });
                        $('.pagination').hide();
                    },
                    error: function(data) {
                        alert('Error filtering users');
                    }
                });
            }

            $('#id, #name, #email, #phone').on('input', function() {
                filter();
            });

            $('#needAssessment, #activeClients').on('change', function() {
                filter();
            });
        });
    </script>
@endpush
