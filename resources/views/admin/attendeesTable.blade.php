<div class="m-auto text-center w-75">
    <h2>Asistentes:</h2>
    <table class="w-100 table">
        <thead>
            <tr>
                <th scope="col">Nombre</th>
                <th scope="col">Peso</th>
                <th scope="col">Talla</th>
                <th scope="col">Kangoo</th>
            </tr>
        </thead>
        <tbody>
        @foreach($event->attendees as $clientSession)
            <tr>
                <td><div style="max-height:3rem; overflow:hidden">{{$clientSession->client->usuario->fullName}}</div></td>
                <td><div style="max-height:3rem; overflow:hidden">{{$clientSession->client->peso() ? $clientSession->client->peso()->peso : ''}}</div></td>
                <td><div style="max-height:3rem; overflow:hidden">{{$clientSession->client->talla_zapato}}</div></td>
                <td><div style="max-height:3rem; overflow:hidden">{{$clientSession->kangoo_id ? $clientSession->kangoo->SKU : ''}}</div></td>
            </tr>
        @endforeach
        <tbody>
    </table>
</div>

