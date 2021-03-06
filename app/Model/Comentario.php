<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Comentario extends Model
{
    protected $table = 'comentarios';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'blog_id',
        'reply_id',
        'nombre',
        'email',
        'comentario',
    ];

    public function replies($orden = 'asc'){
        return $this->hasMany(Comentario::class, 'reply_id', 'id')->orderBy('created_at', $orden);
    }
}
