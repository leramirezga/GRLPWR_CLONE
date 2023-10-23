<?php

namespace App\Model;

use App\PlanClass;
use App\RemainingClass;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientPlan extends Model
{
    use HasFactory;

    /**
     * Transforms dates to carbon
     * @var string[]
     */
    protected $dates = ['created_at', 'updated_at', 'expiration_date'];

    public function plan(){
        return $this->belongsTo(Plan::class)->withTrashed();
    }

    public function allClasses(){
        return $this->hasMany(PlanClass::class, 'plan_id', 'id');
    }

    public function specificClasses(){
        return $this->hasMany(RemainingClass::class, 'client_plan_id', 'id')
            ->where('unlimited', '=', )
            ->where('remaining_classes', '!=', null);
    }

    public function unlimitedClasses(){
        return $this->hasMany(RemainingClass::class, 'client_plan_id', 'id')
            ->where('unlimited', '=', 1);
    }

    public function sharedClasses(){
        return $this->hasMany(RemainingClass::class, 'client_plan_id', 'id')
            ->where('unlimited', '=', 0)
            ->where('remaining_classes', '=', null);
    }

}
