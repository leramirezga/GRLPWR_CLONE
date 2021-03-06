<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Estatura extends Model
{
    protected $table = 'estaturas';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'usuario_id','estatura','unidad_medida'
    ];

    public function getUnidadMedidaAbreviaturaAttribute(){//no se puede llamar UnidadMedida porque crea un bucle con el switch
        switch ($this->unidad_medida){
            case 0:
                return 'm';
            case 1:
                return 'cm';
            case 2:
                return 'in';
        }
    }
}
