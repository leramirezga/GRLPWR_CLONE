<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SesionEvento extends Model
{
    use HasFactory;
    protected $table = 'sesiones_evento';

    protected $dates = ['fecha_inicio', 'fecha_fin'];

    public function evento(){
        return $this->belongsTo(Evento::class);
    }
}
