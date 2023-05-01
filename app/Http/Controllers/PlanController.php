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
        $plans = Plan::all();
        return view('plans', ['plans' => $plans]);
    }

   public function show(Plan $plan){
       return view('plan', [
           'plan' => $plan,
       ]);
   }
}
