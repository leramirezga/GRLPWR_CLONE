<?php

namespace App\Repositories;

use App\Model\ClientPlan;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ClientPlanRepository
{

    public function findValidClientPlan($event = null, int $clientId = null, bool $withRemainingClasses = true, bool $extendedTimeToRenew = false)
    {
        return ClientPlan::where('client_id', $clientId ?? Auth::id())
            ->where(function($q) use ($extendedTimeToRenew) {
                $q->where('client_plans.expiration_date', '>', Carbon::now())//is not expired
                ->when($extendedTimeToRenew, function ($query) {
                    return $query->where(function ($query) {
                        $query->orWhere('client_plans.expiration_date', '>', Carbon::now()->subDays(env('DAYS_TO_RENEW', 7)));//expired 7 days ago
                    });
                });
            })
            ->when($withRemainingClasses, function ($query) {
                return $query->where(function ($query) {
                    $query->where('remaining_shared_classes', '>', 0)
                        ->orWhereNull('remaining_shared_classes');
                });
            })->join('plans', 'client_plans.plan_id', '=', 'plans.id')
            ->select('client_plans.*', 'plans.name')
            ->get();

        /*
         *FIT-57: Uncomment this if you want specific classes
        $clientPlanQuery = ClientPlan::selectRaw(
                ($event ? 'remaining_classes.id as remaining_classes_id, remaining_classes.*, ' : '') . 'client_plans.*, client_plans.id as id'
            )
            ->distinct()
            ->where('client_id', $clientId)
            ->where('expiration_date', '>', now())
            ->join('remaining_classes', 'client_plans.id', 'remaining_classes.client_plan_id')
            ->where(function ($query) use ($event, $withRemainingClasses) {
                $query->where('remaining_classes.unlimited', '=', '1')
                    ->orWhere(function ($innerSubquery) use ($event, $withRemainingClasses) {
                        $innerSubquery->when($event, function ($query, $event) {
                            return $query->where('remaining_classes.class_type_id', $event->class_type_id);
                        })
                        ->where('remaining_classes.unlimited', '=', '0')
                        ->when($withRemainingClasses, function ($query) {
                            return $query->where('remaining_classes.remaining_classes', '>', '0');
                        });
                    })
                    ->orWhere(function ($innerSubquery) use ($event, $withRemainingClasses){
                        $innerSubquery->when($event, function ($query, $event) {
                                return $query->where('remaining_classes.class_type_id', $event->class_type_id);
                            })
                            ->where('remaining_classes.unlimited', '=', '0')
                            ->where('remaining_classes.remaining_classes', '=', null)
                            ->when($withRemainingClasses, function ($query) {
                                return $query->where('client_plans.remaining_shared_classes', '>', 0);
                            });
                    });
            });

            return $clientPlanQuery->get();
        */
    }
}