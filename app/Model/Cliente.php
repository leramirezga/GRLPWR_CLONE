<?php

namespace App\Model;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $table = 'clientes';
    protected $primaryKey = 'usuario_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'usuario_id','peso_ideal','talla_zapato','biotipo'
    ];

    public function usuario(){
        return $this->belongsTo(User::class, 'usuario_id', 'id');
    }

    public function estaturas($orden = 'asc'){
        return $this->hasMany(Estatura::class, 'usuario_id', 'usuario_id')->orderBy('created_at', $orden);
    }

    public function pesos($orden = 'asc'){
        return $this->hasMany(Peso::class, 'usuario_id', 'usuario_id')->orderBy('created_at', $orden);
    }

    public function estatura(){
        return $this->estaturas('desc')->first();
    }

    public function peso(){
        return $this->pesos('desc')->first();
    }

    public function getPorcentajeMetaAttribute(){
        //no se requiere validar si el peso es nulo, porque ya hay una validación en la vista de si existe el cliente. Y si el cliente existe tiene que haber asignado el peso
        return $this->peso_ideal > $this->peso()->peso ? $this->peso()->peso*100/$this->peso_ideal : $this->peso_ideal*100/$this->peso()->peso;
    }
}
