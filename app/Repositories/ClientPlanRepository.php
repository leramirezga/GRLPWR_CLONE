<?php

namespace App\Repositories;

use App\Model\ClientPlan;
use App\Model\Evento;
use Illuminate\Support\Facades\Auth;

class ClientPlanRepository
{

    public function findValidClientPlan(Evento $event = null, bool $withRemainingClasses = true)
    {
        $clientPlanQuery = ClientPlan::selectRaw(
                ($event ? 'remaining_classes.id as remaining_classes_id, remaining_classes.*, ' : '') . 'client_plans.*, client_plans.id as id'
            )
            ->distinct()
            ->where('client_id', Auth::id())
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
    }
}