<?php

namespace App;

use App\Model\SesionCliente;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EditedEvent extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $dates = ['fecha_inicio', 'fecha_fin'];

    public function setFechaInicioAttribute( $value ) {
        $this->attributes['fecha_inicio'] = (new Carbon($value))->format('d-m-Y');
    }

    public function setFechaFinAttribute( $value ) {
        $this->attributes['fecha_fin'] = (new Carbon($value))->format('d-m-Y');
    }

    public function attendees(){
        return $this->hasMany(SesionCliente::class, 'evento_id', 'evento_id')
            ->where('fecha_inicio', '=', Carbon::parse($this->fecha_inicio)->format('Y-m-d') . ' ' . $this->start_hour)
            ->where('fecha_fin', '=', Carbon::parse($this->fecha_fin)->format('Y-m-d') . ' ' . $this->end_hour);
    }

    public function classType(){
        return $this->hasOne(ClassType::class,'id', 'class_type_id');
    }
}
