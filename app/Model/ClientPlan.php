<?php

namespace App\Model;

use App\Exceptions\ShoeSizeNotSupportedException;
use App\Exceptions\WeightNotSupportedException;
use App\PlanClass;
use App\RemainingClass;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

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

    public function clientLastPlanWithRemainingClasses(Request $request){

        $lastPlanWithRemainingClasses = ClientPlan::where('client_id', $request->query('clientId'))
            ->where('remaining_shared_classes', '>', 0)
            ->where(function($q) {
                $q->where('client_plans.expiration_date', '>', Carbon::now())//is not expired
                    ->orWhere('client_plans.expiration_date', '>', Carbon::now()->subDays(env('DAYS_TO_RENEW', 7)));//expired 7 days ago

            })
            ->join('plans', 'client_plans.plan_id', '=', 'plans.id')
            ->select('client_plans.*', 'plans.name')
            ->first();

        return response()->json([
            'success' => true,
            'lastPlanWithRemainingClasses' => $lastPlanWithRemainingClasses
        ], 200);
    }

}
