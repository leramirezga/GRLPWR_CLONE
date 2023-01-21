<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evento extends Model
{
    use HasFactory;
    protected $table = 'eventos';

    protected $fillable = [
        'nombre', 'descripcion', 'imagen', 'info_adicional'
    ];

    public function next(){
        return $this->hasMany(SesionEvento::class)->where('fecha_inicio','>=',\today());
    }

}
