<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class TagsSolicitudServicio extends Model
{
    protected $table = 'tags_solicitud_servicio';

    public function tag(){
        return $this->belongsTo(Tags::class);
    }

    protected $fillable = [
        'tag_id',
        'solicitud_servicio_id',
    ];
}
