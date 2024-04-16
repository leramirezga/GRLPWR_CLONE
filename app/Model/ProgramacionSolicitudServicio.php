<?php

namespace App\Model;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class ProgramacionSolicitudServicio extends Model
{
    protected $table = 'programacion_solicitud_servicio';

    public function getFechaInicioAttribute($time){
        return Carbon::parse($time);
    }
    public function getFechaFinalizacionAttribute($time){
        return Carbon::parse($time);
    }
    public function getHoraInicioLunesAttribute($time){
        return Carbon::parse($time);
    }
    public function getHoraFinLunesAttribute($time){
        return Carbon::parse($time);
    }
    public function getHoraInicioMartesAttribute($time){
        return Carbon::parse($time);
    }
    public function getHoraFinMartesAttribute($time){
        return Carbon::parse($time);
    }
    public function getHoraInicioMiercolesAttribute($time){
        return Carbon::parse($time);
    }
    public function getHoraFinMiercolesAttribute($time){
        return Carbon::parse($time);
    }
    public function getHoraInicioJuevesAttribute($time){
        return Carbon::parse($time);
    }
    public function getHoraFinJuevesAttribute($time){
        return Carbon::parse($time);
    }
    public function getHoraInicioViernesAttribute($time){
        return Carbon::parse($time);
    }
    public function getHoraFinViernesAttribute($time){
        return Carbon::parse($time);
    }
    public function getHoraInicioSabadoAttribute($time){
        return Carbon::parse($time);
    }
    public function getHoraFinSabadoAttribute($time){
        return Carbon::parse($time);
    }
    public function getHoraInicioDomingoAttribute($time){
        return Carbon::parse($time);
    }
    public function getHoraFinDomingoAttribute($time){
        return Carbon::parse($time);
    }
}
