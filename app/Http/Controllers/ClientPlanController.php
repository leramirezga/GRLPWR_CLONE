<?php

namespace App\Http\Controllers;

use App\Model\ClientPlan;
use App\Model\Plan;
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
        $clientPlan->remaining_classes = $plan-> number_of_classes;
        $clientPlan->expiration_date =  Carbon::now()->addDays($plan->duration_days);
        $clientPlan->payment_id = $payment_id;
        $clientPlan->save();
    }
}
