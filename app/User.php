<?php

namespace App;

use App\Model\Blog;
use App\Model\Cliente;
use App\Model\Entrenador;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Model\Review;
use Carbon\Carbon;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'usuarios';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre','apellido_1','apellido_2','rol','email', 'password','nivel','slug','foto'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
    * The attributes that should be mutated to dates.
    *
    * @var array
    */
    protected $dates = ['fecha_nacimiento'];

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName(){
        return 'slug';
    }

    public function reviews(){
        return $this->hasMany(Review::class, 'usuario_id', 'id');
    }

    public function rating(){
        $rating = $this->reviews()->average('rating');
        return $rating;
    }

    public function ratingPorcentage(){
        $rating = $this->reviews()->average('rating')/5;
        return $rating;
    }

    public function cliente(){
        return $this->belongsTo(Cliente::class,'id','usuario_id');
    }

    public function entrenador(){
        return $this->belongsTo(Entrenador::class,'id','usuario_id');
    }

    public function getEdadAttribute(){
        if($this->fecha_nacimiento == null){
            return '';
        }
        return str_after(Carbon::parse($this->fecha_nacimiento)->diffForHumans(), 'hace ');
    }

    public function blogs(){
        return $this->hasMany(Blog::class, 'usuario_id', 'id');
    }
}
