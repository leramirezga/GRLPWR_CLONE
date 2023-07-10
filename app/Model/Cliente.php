<?php

namespace App\Model;

use App\Anthropometry;
use App\CardiovascularRisk;
use App\ExercisePrescription;
use App\FitnessComponent;
use App\MaxHeartRate;
use App\NutritionAndHealth;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cliente extends Model
{
    protected $table = 'clientes';
    protected $primaryKey = 'usuario_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'usuario_id','peso_ideal','talla_zapato','biotipo'
    ];

    public function usuario(){
        return $this->belongsTo(User::class, 'usuario_id', 'id');
    }

    public function estaturas($orden = 'asc'){
        return $this->hasMany(Estatura::class, 'usuario_id', 'usuario_id')->orderBy('created_at', $orden);
    }

    public function pesos($orden = 'asc'){
        return $this->hasMany(Peso::class, 'usuario_id', 'usuario_id')->orderBy('created_at', $orden);
    }

    public function estatura(){
        return $this->estaturas('desc')->first();
    }

    public function peso(){
        return $this->pesos('desc')->first();
    }

    public function anthropometries($order = 'asc')
    {
        return $this->hasMany(Anthropometry::class, 'client_id', 'usuario_id')->orderBy('created_at', $order);
    }

    public function anthropometry()
    {
        return $this->anthropometries('desc')->first();
    }

    public function cardiovascularRisks($order = 'asc')
    {
        return $this->hasMany(CardiovascularRisk::class, 'client_id', 'usuario_id')->orderBy('created_at', $order);
    }

    public function cardiovascularRisk()
    {
        return $this->cardiovascularRisks('desc')->first();
    }

    public function maxHeartRates($order = 'asc')
    {
        return $this->hasMany(MaxHeartRate::class, 'client_id', 'usuario_id')->orderBy('created_at', $order);
    }

    public function maxHeartRate()
    {
        return $this->maxHeartRates('desc')->first();
    }

    public function fitnessComponents($order = 'asc')
    {
        return $this->hasMany(FitnessComponent::class, 'client_id', 'usuario_id')->orderBy('created_at', $order);
    }

    public function fitnessComponent()
    {
        return $this->fitnessComponents('desc')->first();
    }

    public function exercisePrescription()
    {
        $exercisePrescription = $this->hasOne(ExercisePrescription::class, 'client_id', 'usuario_id')->first();
        if($exercisePrescription){
            return json_decode( preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $exercisePrescription->recommendations), true );
        }
        return null;
    }

    public function nutritionAndHealth()
    {
        $nutritionAndHealth = $this->hasOne(NutritionAndHealth::class, 'client_id', 'usuario_id')->first();
        if($nutritionAndHealth){
            return json_decode( preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $nutritionAndHealth->recommendations), true );
        }
        return null;
    }

    public function getPorcentajeMetaAttribute(){
        //no se requiere validar si el peso es nulo, porque ya hay una validación en la vista de si existe el cliente. Y si el cliente existe tiene que haber asignado el peso
        return $this->peso_ideal > $this->peso()->peso ? $this->peso()->peso*100/$this->peso_ideal : $this->peso_ideal*100/$this->peso()->peso;
    }
}
