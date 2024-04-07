<?php

namespace App;

use App\Model\Evento;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HighlightSection extends Model
{
    use HasFactory;

    public function event(){
        return $this->hasOne(Evento::class, 'id', 'event_id');
    }
}
