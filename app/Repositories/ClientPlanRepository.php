<?php

namespace App\Repositories;

use App\Model\ClientPlan;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ClientPlanRepository
{

    public function findValidClientPlans(){
        return $this->findValidClientPlan(multiplePlans: true);
    }

    public function findValidClientPlan($event = null, int $clientId = null, bool $withRemainingClasses = true, bool $extendedTimeToRenew = false, bool $multiplePlans = false)
    {
        /*
        *FIT-57: Uncomment this if you want specific classes*/
        if(!$multiplePlans && $event){
            $clientPlan = ClientPlan::selectRaw(
                'remaining_classes.id as remaining_classes_id, remaining_classes.*, client_plans.*, plans.name, client_plans.id as id'
            )
            ->distinct()
            ->where('client_id', $clientId ?? Auth::id())
            ->where('client_plans.expiration_date', '>', now())
            ->where('client_plans.expiration_date', '>', $event->fecha_fin)
            ->when($extendedTimeToRenew, function ($query, $extendedTimeToRenew) {
                return $query->orWhere('client_plans.expiration_date', '>', Carbon::now()->subDays(env('DAYS_TO_RENEW', 7)));//expired 7 days ago
            })
            ->join('remaining_classes', 'client_plans.id', 'remaining_classes.client_plan_id')
            ->join('plans', 'client_plans.plan_id', '=', 'plans.id')->get();

            if($clientPlan && $clientPlan->isNotEmpty()){
                $clientPlan = $clientPlan ->first();
                if ($clientPlan->class_type_id == $event->class_type_id){
                    if($withRemainingClasses){
                        if($clientPlan->unlimited == 1 || $clientPlan->remaining_classes > 0) {
                            return $clientPlan;
                        }
                        return null;
                    }
                    return $clientPlan;
                }
                return null;
            }
        }
        /*FIT-57: End of commented block*/


        $clientPlan = ClientPlan::where('client_id', $clientId ?? Auth::id())
            ->where('client_plans.expiration_date', '>', Carbon::now())//is not expired
            ->when($event, function ($query) use ($event) {
                return $query->where('client_plans.expiration_date', '>', $event->fecha_fin);
            })
            ->when($extendedTimeToRenew, function ($query, $extendedTimeToRenew) {
                    return $query->orWhere('client_plans.expiration_date', '>', Carbon::now()->subDays(env('DAYS_TO_RENEW', 7)));//expired 7 days ago
            })
            ->when($withRemainingClasses, function ($query) {
                return $query->where(function ($query) {
                    $query->where('remaining_shared_classes', '>', 0)
                        ->orWhereNull('remaining_shared_classes');
                });
            })->join('plans', 'client_plans.plan_id', '=', 'plans.id')
            ->select('client_plans.*', 'plans.name')
            ->get();

        if($multiplePlans){
            return $clientPlan;
        }
        return$clientPlan && $clientPlan->isNotEmpty() ?
             $clientPlan->first() : null;
    }
}