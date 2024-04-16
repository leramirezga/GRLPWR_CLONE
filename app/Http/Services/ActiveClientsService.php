<?php

namespace App\Http\Services;

use App\HistoricalActiveClient;
use App\Model\ClientPlan;
use Illuminate\Support\Facades\Log;

class ActiveClientsService
{
    public function saveActiveClients($date):void
    {
        $count = ClientPlan::where('created_at', '<=', $date)
            ->where('expiration_date', '>=', $date)
            ->count();

        Log::info('Active clients at: ' . $date . ' - ' . $count);

        HistoricalActiveClient::updateOrCreate(
            ['date' => $date],
            ['active_clients' => $count]
        );
    }
}