<?php

namespace App\Jobs;

use App\Http\Services\ActiveAndRetainedClientsService;
use Carbon\Carbon;

class CalculateActiveClients
{
    public function __construct()
    {}

    /**
     * Calculates the number of active clients for certain day to update or create the registry in historical_active_clients table.
     *
     * @return void
     */
    public function __invoke(): void
    {
        $activeClientsService = new ActiveAndRetainedClientsService();
        $activeClientsService->saveActiveClients(Carbon::now()->subDays(5));
    }
}
