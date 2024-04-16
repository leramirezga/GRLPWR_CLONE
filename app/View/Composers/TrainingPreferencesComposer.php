<?php

namespace App\View\Composers;

use App\TrainingPreference;
use Illuminate\Support\Facades\Route;
use Illuminate\View\View;

class TrainingPreferencesComposer
{
    /**
     * Bind data to the view.
     */
    public function compose(View $view): void
    {
        $route = Route::current(); // Illuminate\Routing\Route
        $trainingPreferences =  TrainingPreference::where('user_id', $route->parameter('user')->id)
            ->orderBy('created_at', 'desc')->first();

        $view->with([
            'trainingPreferences' => $trainingPreferences,
        ]);
    }
}