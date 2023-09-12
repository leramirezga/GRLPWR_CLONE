<?php

namespace App\Model;

use App\ClassType;
use App\EditedEvent;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evento extends Model
{
    use HasFactory;
    protected $table = 'eventos';

    protected $fillable = [
        'nombre', 'descripcion', 'imagen', 'info_adicional', 'branch_id', 'class_type_id',
        'lugar', 'cupos', 'precio', 'precio_sin_implementos', 'descuento', 'oferta', 'repeatable',
        'fecha_inicio', 'fecha_fin', 'start_hour', 'end_hour'
    ];

    protected $dates = ['fecha_inicio', 'fecha_fin'];

    public function attendees(){
        return $this->hasMany(SesionCliente::class, 'evento_id', 'id')
            ->where('fecha_inicio', '=', Carbon::parse($this->fecha_inicio)->format('Y-m-d') . ' ' . $this->start_hour)
            ->where('fecha_fin', '=', Carbon::parse($this->fecha_fin)->format('Y-m-d') . ' ' . $this->end_hour);
    }

    public function edited_events(){
        return $this->hasMany(EditedEvent::class, 'evento_id', 'id');
    }

    public function classType(){
        return $this->hasOne(ClassType::class,'id', 'class_type_id');
    }
}
