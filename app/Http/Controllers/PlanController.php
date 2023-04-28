<?php

namespace App\Http\Controllers;

use App\Model\Plan;
use Validator;

class PlanController extends Controller
{

   public function show(Plan $plan){
       return view('plan', [
           'plan' => $plan,
       ]);
   }
}
