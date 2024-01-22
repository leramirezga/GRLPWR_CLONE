<div class="m-auto text-center w-75">
    <h2>Asistentes:</h2>
    <table class="w-100 table">
        <thead>
            <tr>
                <th scope="col">Id</th>
                <th scope="col">Nombre</th>
                <th scope="col">Es cortesía</th>
                @if(strcasecmp($event->classType->type, \App\Utils\PlanTypesEnum::Kangoo->value) == 0)
                    <th scope="col">Peso</th>
                    <th scope="col">Talla</th>
                    <th scope="col">Kangoo</th>
                @endif
            </tr>
        </thead>
        <tbody>
        @foreach($event->attendees as $clientSession)
            <tr>
                <td><div style="max-height:3rem; overflow:hidden">{{$clientSession->client->usuario_id}}</div></td>
                <td><div style="max-height:3rem; overflow:hidden">{{$clientSession->client->usuario->fullName}}</div></td>
                <td><div style="max-height:3rem; overflow:hidden">{{$clientSession->is_courtesy ? 'Si' : 'No'}}</div></td>
                @if(strcasecmp($event->classType->type, \App\Utils\PlanTypesEnum::Kangoo->value) == 0)
                    <td><div style="max-height:3rem; overflow:hidden">{{$clientSession->client->peso() ? $clientSession->client->peso()->peso : ''}}</div></td>
                    <td><div style="max-height:3rem; overflow:hidden">{{$clientSession->client->talla_zapato}}</div></td>
                    <td><div style="max-height:3rem; overflow:hidden">{{$clientSession->kangoo_id ? $clientSession->kangoo->SKU : ''}}</div></td>
                @endif
            </tr>
        @endforeach
        <tbody>
    </table>

    <button class="btn btn-success" data-toggle="modal" data-target="#registerAttendee">
        Registrar Asistente
    </button>
</div>

@include('components/modalRegisterAttendee')

