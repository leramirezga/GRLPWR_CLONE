<?php

namespace App\Http\Controllers;

use App\Model\Cliente;
use App\Model\ClientPlan;
use App\Model\Plan;
use App\Model\TransaccionesPagos;
use App\PaymentMethod;
use App\RemainingClass;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class ClientPlanController extends Controller
{
    public function save(int $clientId,int $planId, int $payment_id, int $accumulativeClasses = 0)
    {
        $clientPlan = new ClientPlan();
        $clientPlan->client_id = $clientId;
        $plan = Plan::find($planId);
        $clientPlan->plan_id = $planId;
        $clientPlan->remaining_shared_classes = $plan-> number_of_shared_classes + $accumulativeClasses;
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

    public function showLoadClientPlan(){
        $clients = Cliente::all();
        $paymentMethods = PaymentMethod::where('enabled', true)->get();
        $enabledPlans = Plan::all();
        return view('admin.clientPlan.saveClientPlan', compact('clients', 'paymentMethods', 'enabledPlans'));

    }

    public function saveClientPlan(Request $request){
        DB::beginTransaction();

        try {
            $transaction = new TransaccionesPagos();
            $transaction->payment_method_id = $request->paymentMethodId;
            $transaction->ref_payco = "1";
            $transaction->codigo_respuesta = "1";
            $transaction->respuesta = "Aprobado";
            $transaction->amount = $request->amount;
            $transaction->data = $request->data ?? "";
            $transaction->user_id = $request->clientId;
            $transaction->save();

            $this->save($request->clientId, $request->planId, $transaction->id, $request->accumulateClasses === "on" ? (int)($request->remainingClases) : 0);
            Session::put('msg_level', 'success');
            Session::put('msg', __('general.success_save_client_plan'));
            Session::save();
            DB::commit();
            return redirect()->back();
        }catch (Exception $exception) {
            DB::rollBack();
            Log::error("ERROR ClientPlanController - saveClientPlan: " . $exception->getMessage());
            Session::put('msg_level', 'danger');
            Session::put('msg', __('general.error_save_client_plan'));
            Session::save();
            return redirect()->back();
        }
    }
}
