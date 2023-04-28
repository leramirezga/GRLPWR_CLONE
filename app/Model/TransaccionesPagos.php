<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TransaccionesPagos extends Model
{
    protected $table = 'transacciones_pagos';
    use SoftDeletes;

    protected $fillable = [
        'ref_payco', 'payment_method_id', 'codigo_respuesta','respuesta','data', 'user_id',
    ];

}
