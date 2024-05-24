<?php

namespace App\Http\Controllers;

use App\Model\TransaccionesPagos;
use Illuminate\Http\Request;
use Validator;

class AccountingFlowController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function AccountingFlow(request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $positiveValues = collect();
        $negativeValues = collect();
        if ($startDate && $endDate) {
            $positiveValues = TransaccionesPagos::with(['user', 'payment'])
                ->where('amount', '>', 0)
                ->whereBetween('created_at', [$startDate, $endDate])
                ->get();
            $negativeValues = TransaccionesPagos::with(['user', 'payment'])
                ->where('amount', '<', 0)
                ->whereBetween('created_at', [$startDate, $endDate])
                ->get();
        }
        $positiveSum = $positiveValues->sum('amount');
        $negativeSum = $negativeValues->sum('amount');
        return view('cliente.AccountingFlow', compact('positiveValues', 'negativeValues', 'positiveSum', 'negativeSum'));
    }
}
