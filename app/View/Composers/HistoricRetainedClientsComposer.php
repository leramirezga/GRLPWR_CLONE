<?php

namespace App\View\Composers;

use App\HistoricalActiveClient;
use App\Http\Services\ActiveAndRetainedClientsService;
use Illuminate\View\View;

class HistoricRetainedClientsComposer
{
    /**
     * Bind data to the view.
     */
    public function compose(View $view): void
    {
        $historicalData = HistoricalActiveClient::orderBy('date')->get();

        $retainedClientsData = $historicalData->pluck('retained_clients');
        $dates = $historicalData->pluck('date')->toJson();

        $datasets = [
            [
                'label' => 'Historico clientes retenidos',
                'data' => $retainedClientsData,
                'backgroundColor' => 'rgba(75, 192, 192, 0.2)',
                'borderColor' => 'rgba(75, 192, 192, 1)',
                'borderWidth' => 1,
            ],
        ];

        $view->with([
            'labels2' => $dates,
            'datasets2' => $datasets,
        ]);
    }
}