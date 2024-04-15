<?php

namespace App\Http\Services;

use App\HistoricalActiveClient;
use App\Model\ClientPlan;

class ActiveClientsService
{
    public function saveActiveClients($currentDate):void
    {
        $count = ClientPlan::where('created_at', '<=', $currentDate)
            ->where('expiration_date', '>=', $currentDate)
            ->count();

        HistoricalActiveClient::updateOrCreate(
            ['date' => $currentDate],
            ['active_plans_count' => $count]
        );
    }
}