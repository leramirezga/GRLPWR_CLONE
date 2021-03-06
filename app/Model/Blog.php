<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    protected $table = 'blogs';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'usuario_id',
        'titulo',
        'portada',
        'contenido',
        'tipo',
        'slug',
    ];

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName(){
        return 'slug';
    }

    public function comentarios($orden = 'desc'){
        return $this->hasMany(Comentario::class, 'blog_id', 'id')->where('reply_id', null)->orderBy('created_at', $orden);
    }
}
