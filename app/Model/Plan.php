<?php

namespace App\Model;

use App\PlanBenefit;
use App\PlanClass;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Plan extends Model
{
    use HasFactory;
    protected $table = 'plans';
    use SoftDeletes;

    /**
     * Transforms dates to carbon
     * @var string[]
     */
    protected $dates = ['created_at', 'updated_at', 'expiration_date'];

    public function allClasses(){
        return $this->hasMany(PlanClass::class, 'plan_id', 'id');
    }

    public function unlimitedClasses(){
        return $this->hasMany(PlanClass::class, 'plan_id', 'id')
            ->where('unlimited', '=', 1);
    }

    public function specificClasses(){
        return $this->hasMany(PlanClass::class, 'plan_id', 'id')
            ->where('unlimited', '=', 0)
            ->where('number_of_classes', '!=', null);
    }

    public function sharedClasses(){
        return $this->hasMany(PlanClass::class, 'plan_id', 'id')
            ->where('unlimited', '=', 0)
            ->where('number_of_classes', '=', null);
    }

    public function benefits(){
        return $this->hasMany(PlanBenefit::class, 'plan_id', 'id');
    }
}
