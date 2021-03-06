<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\User;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ofrecimientos extends Model
{
    use SoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    protected $table = 'ofrecimientos';

    protected $fillable = [
        'solicitud_servicio_id',
        'usuario_id',
        'precio',
    ];

    public function entrenador(){
        return $this->belongsTo(User::class, 'usuario_id', 'id');
    }

    public function solicitudServicio(){
        return $this->belongsTo(SolicitudServicio::class, 'solicitud_servicio_id', 'id');
    }
}
