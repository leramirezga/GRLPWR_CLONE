<?php

namespace App\Jobs;

use App\Http\Services\ActiveClientsService;
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
        $activeClientsService = new ActiveClientsService();
        $activeClientsService->saveActiveClients(Carbon::now()->subDays(5));
    }
}
