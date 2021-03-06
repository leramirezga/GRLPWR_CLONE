<?php

namespace App\Model;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class HorarioSolicitudServicio extends Model
{
    protected $table = 'horarios_solicitud_servicio';

    /**
     * HorarioSolicitudServicio constructor.
     * @param array $attributes
     */
    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);

        setlocale(LC_TIME, 'es');//Esto es necesario para obtener el nombre de los días en español
    }

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'solicitud_servicio_id',
        'fecha',
        'hora_inicio',
        'hora_fin',
        'estado',
    ];

    public function getFechaAttribute($date)
    {
        return Carbon::parse($date);
    }

    public function getHoraInicioAttribute($time)
    {
        return Carbon::parse($time);
    }

    public function getHoraFinAttribute($horaFin)
    {
        return Carbon::parse($horaFin);
    }

    public function diaEvento(){
            //dd(utf8_encode(strftime("%A",$this->fecha->getTimestamp())));
        return utf8_encode(strftime("%A",$this->fecha->getTimestamp()));
    }

    public function solicitudServicio(){
        return $this->belongsTo(SolicitudServicio::class, 'solicitud_servicio_id', 'id');
    }

}
