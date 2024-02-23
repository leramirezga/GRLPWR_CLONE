<?php

namespace App\Jobs;

use App\DTO\ExpirationInfo;
use App\Model\ClientPlan;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class CheckClientPlansExpiration
{
    public function __construct()
    {}

    /**
     * Check all the plans that will expire in the next 3 days and sends a message to remind them to renew.
     *
     * @return void
     */
    public function __invoke(): void
    {
        DB::transaction(function () {

            $initialDate = Carbon::now()->subDays(3)->startOfDay();
            $finalDate = Carbon::now()->endOfDay();
            $usersInfo =
                ClientPlan::join('usuarios', 'usuarios.id', 'client_plans.client_id')
                ->where('expiration_date', '>=', $initialDate)
                ->where('expiration_date', '<=', $finalDate)
                ->where('scheduled_renew_msg', '0')
                ->select('usuarios.telefono', 'client_plans.expiration_date')
                ->get();

            ClientPlan::
                where('expiration_date', '>=', $initialDate)
                ->where('expiration_date', '<=', $finalDate)
                ->where('scheduled_renew_msg', '0')
                ->update(['scheduled_renew_msg' => '1']);

            $usersInfo->each(function ($info) {
                $expirationInfo = new ExpirationInfo($info->telefono, $info->expiration_date);
                dispatch(new SendMessageToRenewPlan($expirationInfo));
            });
        });
    }
}
