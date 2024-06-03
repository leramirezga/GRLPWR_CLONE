<?php

namespace App\Http\Controllers;

use App\Model\TransaccionesPagos;
use App\Utils\FeaturesEnum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AccountingFlowController extends Controller
{
    public function AccountingFlow(Request $request)
    {
        $request->validate([
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $positiveValuesMayorCash = collect();
        $positiveMayorCashSum = 0;
        $negativeValuesMayorCash = collect();
        $negativeMayorCashSum = 0;
        $positiveValuesPettyCash = collect();
        $positivePettyCashSum = 0;
        $negativeValuesPettyCash = collect();
        $negativePettyCashSum = 0;

        $user = Auth::user();

        if ($user->hasFeature(FeaturesEnum::SEE_PETTY_CASH)) {
            //Loads with user and payment to see the name of the user that made the transaction and the payment method used for the transaction
            $positiveValuesPettyCash = TransaccionesPagos::with(['user', 'payment'])
                ->where('amount', '>', 0)
                ->where('is_petty_cash', '=', 1)
                ->whereBetween('created_at', [$startDate, $endDate])
                ->get();

            $positivePettyCashSum = $positiveValuesPettyCash->sum('amount');

            $negativeValuesPettyCash = TransaccionesPagos::with(['user', 'payment'])
                ->where('amount', '<', 0)
                ->where('is_petty_cash', '=', 0)
                ->whereBetween('created_at', [$startDate, $endDate])
                ->get();

            $negativePettyCashSum = $negativeValuesPettyCash->sum('amount');
        }

        if ($user->hasFeature(FeaturesEnum::SEE_MAYOR_CASH)) {
            //Loads with user and payment to see the name of the user that made the transaction and the payment method used for the transaction
            $positiveValuesMayorCash = TransaccionesPagos::with(['user', 'payment'])
                ->where('amount', '>', 0)
                ->where('is_petty_cash', '=', 0)
                ->whereBetween('created_at', [$startDate, $endDate])
                ->get();

            $positiveMayorCashSum = $positiveValuesMayorCash->sum('amount');

            $negativeValuesMayorCash = TransaccionesPagos::with(['user', 'payment'])
                ->where('amount', '<', 0)
                ->where('is_petty_cash', '=', 0)
                ->whereBetween('created_at', [$startDate, $endDate])
                ->get();

            $negativeMayorCashSum = $negativeValuesMayorCash->sum('amount');
        }
        return view('cliente.AccountingFlow',
            compact(
                'positiveValuesPettyCash',
                'positivePettyCashSum',
                'negativeValuesPettyCash',
                'negativePettyCashSum',
                'positiveValuesMayorCash',
                'positiveMayorCashSum',
                'negativeValuesMayorCash',
                'negativeMayorCashSum'));
    }
}
