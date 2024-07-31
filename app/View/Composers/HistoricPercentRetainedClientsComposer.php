<?php

namespace App\View\Composers;

use App\HistoricalActiveClient;
use App\Http\Services\ActiveAndRetainedClientsService;
use Illuminate\View\View;

class HistoricPercentRetainedClientsComposer
{
    /**
     * Bind data to the view.
     */
    public function compose(View $view): void
    {
        $historicalData = HistoricalActiveClient::orderBy('date')->get();
        $percentRetainedClientsData = $historicalData->pluck('percent_retained_clients');
        $dates = $historicalData->pluck('date')->toJson();

        $datasets = [
            [
                'label' => 'Historico porcentaje clientes retenidos',
                'data' => $percentRetainedClientsData,
                'backgroundColor' => 'rgba(255, 159, 64, 0.2)',
                'borderColor' => 'rgba(255, 159, 64, 1)',
                'borderWidth' => 1,
            ],
        ];

        $view->with([
            'labels3' => $dates,
            'datasets3' => $datasets,
        ]);
    }
}