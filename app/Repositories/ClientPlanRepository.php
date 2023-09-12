<?php

namespace App\Repositories;

use App\Model\ClientPlan;
use Illuminate\Support\Facades\Auth;

class ClientPlanRepository
{

    public function findValidClientPlan($event = null)
    {
        $clientPlanQuery = ClientPlan::selectRaw(
                'client_plans.*, remaining_classes.id as remaining_classes_id, remaining_classes.*, client_plans.id as id'
            )
            ->where('client_id', Auth::id())
            ->where('expiration_date', '>', now())
            ->join('remaining_classes', 'client_plans.id', 'remaining_classes.client_plan_id')
            ->where(function ($query) {
                $query->where('remaining_classes.unlimited', '=', '1')
                    ->orWhere(function ($innerSubquery) {
                        $innerSubquery->where('remaining_classes.unlimited', '=', '0')
                            ->where('remaining_classes.remaining_classes', '>', '0');
                    })
                    ->orWhere(function ($innerSubquery){
                        $innerSubquery->where('remaining_classes.unlimited', '=', '0')
                            ->where('remaining_classes.remaining_classes', '=', null)
                            ->where('client_plans.remaining_shared_classes', '>', 0);
                    });
            });

            if (isset($event)) {
                $clientPlanQuery->where('remaining_classes.class_type_id', $event->class_type_id);
            }
            return $clientPlanQuery->get();
    }
}