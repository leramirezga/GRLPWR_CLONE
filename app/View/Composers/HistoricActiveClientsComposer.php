<?php

namespace App\View\Composers;

use App\HistoricalActiveClient;
use Illuminate\View\View;

class HistoricActiveClientsComposer
{
    /**
     * Bind data to the view.
     */
    public function compose(View $view): void
    {
        $historicalData = HistoricalActiveClient::orderBy('date')->get();

        $activeClientsData = $historicalData->pluck('active_clients');
        $activeNewClientsData = $historicalData->pluck('active_new_clients');
        $activeOldClientsData = $historicalData->pluck('active_old_clients');
        $dates = $historicalData->pluck('date')->toJson();

        $datasets = [
            [
                'label' => 'Historico clientes activos',
                'data' => $activeClientsData,
                'backgroundColor' => 'rgba(75, 192, 192, 0.2)',
                'borderColor' => 'rgba(75, 192, 192, 1)',
                'borderWidth' => 1,
            ],
            [
                'label' => 'Historico clientes Nuevos',
                'data' => $activeNewClientsData,
                'backgroundColor' => 'rgba(255, 159, 64, 0.2)',
                'borderColor' => 'rgba(255, 159, 64, 1)',
                'borderWidth' => 1,
            ],
            [
                'label' => 'Historico clientes Antiguos',
                'data' => $activeOldClientsData,
                'backgroundColor' => 'rgba(153, 102, 255, 0.2)',
                'borderColor' => 'rgba(153, 102, 255, 1)',
                'borderWidth' => 1,
            ],
        ];

        $view->with([
            'labels' => $dates,
            'datasets' => $datasets,
        ]);
    }
}