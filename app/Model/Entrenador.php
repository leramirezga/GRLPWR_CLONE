<?php

namespace App\Model;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Entrenador extends Model
{
    protected $table = 'entrenadores';
    protected $primaryKey = 'usuario_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'usuario_id','tipo_cuenta','banco','numero_cuenta','tarifa'
    ];


    public function usuario(){
        return $this->belongsTo(User::class, 'usuario_id', 'id');
    }
}
