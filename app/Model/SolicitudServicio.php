<?php

namespace App\Model;

use App\Utils\Constantes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class SolicitudServicio extends Model
{
    use SoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    protected $table = 'solicitudes_servicio';

    protected $distancia;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'usuario_id',
        'titulo',
        'descripcion',
        'ciudad',
        'direccion',
        'latitud',
        'longitud',
        'estado',
        'oferta_aceptada',
        'tipo'
    ];

    public function ofertaAceptada(){
        return $this->belongsTo(Ofrecimientos::class, 'oferta_aceptada', 'id');
    }

    public function horarios(){
        return $this->hasMany(HorarioSolicitudServicio::class);
    }

    public function horariosAgendados(){
        $horariosActivos = $this->horarios()->where('estado', '=',0);
        switch (Auth::user()->rol){
            case Constantes::ROL_CLIENTE:
                return $horariosActivos->where(function($q) {
                    $q->where('finalizado_cliente', '!=', true)
                        ->orWhere('finalizado_cliente', null);
                });
            case Constantes::ROL_ENTRENADOR:
                return $horariosActivos->where(function($q) {
                    $q->where('finalizado_entrenador', '!=', true)
                        ->orWhere('finalizado_entrenador', null);
                });
        }
        return null;
    }

    public function programacion(){
        return $this->hasOne(ProgramacionSolicitudServicio::class);
    }

    public function ofrecimientos(){
        return $this->hasMany(Ofrecimientos::class);
    }

    public function tags(){
        return $this->hasMany(TagsSolicitudServicio::class);
    }

    public function cliente(){
        return $this->belongsTo(Cliente::class, 'usuario_id', 'usuario_id');
    }

    public function scopeCiudades($query, $ciudades)
    {
        if (!empty($ciudades)) {
            return $query->whereIn('ciudad', $ciudades);
        }
        else {
            return $query;
        }
    }

    public function scopeTag($query, $tags)
    {
        if (!empty($tags)) {
            return $query->join('tags_solicitud_servicio', 'solicitudes_servicio.id', 'tags_solicitud_servicio.solicitud_servicio_id')
                ->whereIn('tags_solicitud_servicio.tag_id', $tags)
                ->select('solicitudes_servicio.*')
                ->distinct();
        }
        else {
            return $query;
        }
    }

    public function scopeEntrenamientosAgendados($query, $tipoUsuario){
        $query = $query->join('horarios_solicitud_servicio', 'solicitudes_servicio.id', 'horarios_solicitud_servicio.solicitud_servicio_id')
            ->where('solicitudes_servicio.estado', 1)//solicitud contratada
            ->where('horarios_solicitud_servicio.estado', 0);//horario activo
        switch ($tipoUsuario){
            case Constantes::ROL_CLIENTE:
                return $query->where(function($q) {
                                    $q->where('horarios_solicitud_servicio.finalizado_cliente', '!=', true)
                                        ->orWhere('horarios_solicitud_servicio.finalizado_cliente', null);
                                })
                                ->select('solicitudes_servicio.*')
                                ->distinct();
            case Constantes::ROL_ENTRENADOR:
                return $query->where(function($q) {
                                    $q->where('horarios_solicitud_servicio.finalizado_entrenador', '!=', true)
                                        ->orWhere('horarios_solicitud_servicio.finalizado_entrenador', null);
                                })
                                ->select('solicitudes_servicio.*')
                                ->distinct();
        }
        return null;
    }
}
