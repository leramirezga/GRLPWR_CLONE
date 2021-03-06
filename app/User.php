<?php

namespace App;

use App\Model\Blog;
use App\Model\Cliente;
use App\Model\Entrenador;
use App\Model\Ofrecimientos;
use App\Model\SolicitudServicio;
use App\Utils\Constantes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Model\Review;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

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

    public function caloriasTotales(){
        $caloriasTotales = 0;
        foreach ($this->entrenamientos() as $entrenamiento){
            $caloriasTotales += $entrenamiento->calorias;
        }
        return $caloriasTotales;
    }

    public function entrenamientosRealizados(){
        $query = DB::table('solicitudes_servicio')
            ->join('horarios_solicitud_servicio', 'solicitudes_servicio.id', 'horarios_solicitud_servicio.solicitud_servicio_id')
            ->where('solicitudes_servicio.estado', 1)//solicitud contratada
            ->where('horarios_solicitud_servicio.estado', 0);//activo

        if(strcasecmp ($this->rol, Constantes::ROL_CLIENTE ) == 0) {
            $query = $query->where('solicitudes_servicio.usuario_id', $this->id)
                            ->where('horarios_solicitud_servicio.finalizado_cliente', 1);

        }
        if(strcasecmp ($this->rol, Constantes::ROL_ENTRENADOR ) == 0) {
            $ofrecimientos = $this->hasMany(Ofrecimientos::class, 'usuario_id', 'id')->get();
            $ofrecimientos_id = array();
            foreach ($ofrecimientos as $ofrecimiento){
                array_push($ofrecimientos_id, $ofrecimiento->id);
            }
            $query = $query->whereIn('oferta_aceptada', $ofrecimientos_id)
                            ->where('horarios_solicitud_servicio.finalizado_entrenador', 1);
        }
        return $query->select('solicitudes_servicio.*')->get();
    }

    public function ofrecimientos(){
       return $this->hasMany(Ofrecimientos::class, 'usuario_id', 'id');
    }

    public function blogs(){
        return $this->hasMany(Blog::class, 'usuario_id', 'id');
    }
}
