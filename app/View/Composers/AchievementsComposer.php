<?php

namespace App\View\Composers;

use App\Achievements\RecordWeeksTrained;
use App\Achievements\WeeksTrained;
use Illuminate\Support\Facades\Route;
use Illuminate\View\View;

class AchievementsComposer
{
    /**
    * Bind data to the view.
    */
    public function compose(View $view): void
    {
        $route = Route::current();
        $user = $route->parameter('user');
        $weeksStreak = $user->achievementStatus(new WeeksTrained());
        $recordWeeksStreak = $user->achievementStatus(new RecordWeeksTrained());

        $view->with([
            'weeksStreak' => $weeksStreak,
            'recordWeeksStreak' => $recordWeeksStreak,
        ]);
    }
}