<?php

namespace App\Http\Controllers;

use App\Model\SesionCliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;

class SesionClienteController extends Controller
{
    public function save(int $sesionEventoId, $clienteId)

    {
        //Se verifica si la sesion ya existía para asignar los kangoo
        if (DB::table('sesiones_cliente')
            ->where('cliente_id', $clienteId)
            ->where('sesion_evento_id', $sesionEventoId)->doesntExist()) {
            $sesionCliente = new SesionCliente();
            $sesionCliente->cliente_id = $clienteId;
            $sesionCliente->sesion_evento_id = $sesionEventoId;
            $sesionCliente->save();
        }
    }
}
