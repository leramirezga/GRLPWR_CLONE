<?php

namespace App;

use App\Model\SesionCliente;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EditedEvent extends Model
{
    use HasFactory;

    public function attendees(){
        return $this->hasMany(SesionCliente::class, 'evento_id', 'evento_id')
            ->where('fecha_inicio', '=', Carbon::parse($this->fecha_inicio)->format('Y-m-d') . ' ' . $this->start_hour)
            ->where('fecha_fin', '=', Carbon::parse($this->fecha_fin)->format('Y-m-d') . ' ' . $this->end_hour);
    }
}
