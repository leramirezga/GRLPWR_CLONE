<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Peso extends Model
{
    protected $table = 'pesos';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'usuario_id','peso','unidad_medida'
    ];

    public function getUnidadMedidaAbreviaturaAttribute(){//no se puede llamar UnidadMedida porque crea un bucle con el switch
        switch ($this->unidad_medida){
            case 0:
                return 'kg';
            case 1:
                return 'lbs';
        }
    }
}
