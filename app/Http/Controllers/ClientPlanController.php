<?php

namespace App\Http\Controllers;

use App\Model\ClientPlan;
use App\Model\Plan;
use App\RemainingClass;
use Carbon\Carbon;
use Validator;

class ClientPlanController extends Controller
{
    public function save(int $clientId,int $planId, int $payment_id)
    {
        $clientPlan = new ClientPlan();
        $clientPlan->client_id = $clientId;
        $plan = Plan::find($planId);
        $clientPlan->plan_id = $planId;
        $clientPlan->remaining_shared_classes = $plan-> number_of_shared_classes;
        $clientPlan->expiration_date =  Carbon::now()->addDays($plan->duration_days);
        $clientPlan->payment_id = $payment_id;
        $clientPlan->save();

        foreach ($plan->allClasses as $class){
            $remainingClass =new RemainingClass();
            $remainingClass->client_plan_id = $clientPlan->id;
            $remainingClass->class_type_id = $class->class_type_id;
            $remainingClass->unlimited = $class->unlimited;
            $remainingClass->remaining_classes = $class->number_of_classes;
            $remainingClass->equipment_included = $class->equipment_included;
            $remainingClass->save();
        }
    }
}
