<?php

namespace App\Model;

use App\EditedEvent;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evento extends Model
{
    use HasFactory;
    protected $table = 'eventos';

    protected $fillable = [
        'nombre', 'descripcion', 'imagen', 'info_adicional'
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


}
