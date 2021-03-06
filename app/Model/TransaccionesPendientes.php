<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class TransaccionesPendientes extends Model
{
    protected $table = 'transacciones_pendientes';

    protected $fillable = [
        'id_transaccion','verificada'
    ];

    public function transaccion(){
        return $this->belongsTo(TransaccionesPagos::class, 'id_transaccion', 'id');
    }

}
