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
                <td>{{$clientSession->client->usuario->nombre}}</td>
                <td>{{$clientSession->client->peso()->peso}}</td>
                <td>{{$clientSession->client->talla_zapato}}</td>
                <td>{{$clientSession->kangoo_id ? $clientSession->kangoo->SKU : ''}}</td>
            </tr>
        @endforeach
        <tbody>
    </table>
</div>

