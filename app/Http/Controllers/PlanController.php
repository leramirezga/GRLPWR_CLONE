<?php

namespace App\Http\Controllers;

use App\Model\Plan;
use Illuminate\Contracts\View\View;
use Validator;

class PlanController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index()
    {
        $plans = $this->enabledPlans();
        return view('plans', ['plans' => $plans]);
    }


    public function enabledPlans()
    {
        return Plan::where(function($q) {
            $q->where('available_plans', '>', 0)
                ->orWhereNull('available_plans');
            })
            ->whereNull('deleted_at')
            ->get();
    }

   public function show(Plan $plan){
       return view('plan', [
           'plan' => $plan,
       ]);
   }
}
