<?php

namespace App\View\Composers;

use App\Achievements\FamilyAndFriendsAchievement;
use App\Achievements\HealthAchievement;
use App\Achievements\HomeAchievement;
use App\Achievements\LeisureAchievement;
use App\Achievements\LoveAchievement;
use App\Achievements\MoneyAchievement;
use App\Achievements\PersonalGrowthAchievement;
use App\Achievements\RecordWeeksTrained;
use App\Achievements\WeeksTrained;
use App\Achievements\WorkAchievement;
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

        $achievementsObjects = [
            'weeksStreak' => new WeeksTrained(),
            'recordWeeksStreak' => new RecordWeeksTrained(),
            'healthAchievement' => new HealthAchievement(),
            'loveAchievement' => new LoveAchievement(),
            'familyAndFriendsAchievement' => new FamilyAndFriendsAchievement(),
            'homeAchievement' => new HomeAchievement(),
            'leisureAchievement' => new LeisureAchievement(),
            'moneyAchievement' => new MoneyAchievement(),
            'workAchievement' => new WorkAchievement(),
            'personalGrowthAchievement' => new PersonalGrowthAchievement(),
        ];
        $achievementStatuses = [];
        foreach ($achievementsObjects as $achievement) {
            $achievementType = get_class($achievement);
            $achievementStatuses[$achievementType] = $user->achievementStatus($achievement);
        }
        $view->with([
            'weeksStreak' => $achievementStatuses[WeeksTrained::class] ?? null,
            'recordWeeksStreak' => $achievementStatuses[RecordWeeksTrained::class] ?? null,
            'healthAchievement' => $achievementStatuses[HealthAchievement::class] ?? null,
            'loveAchievement' => $achievementStatuses[LoveAchievement::class] ?? null,
            'familyAndFriendsAchievement' => $achievementStatuses[FamilyAndFriendsAchievement::class] ?? null,
            'homeAchievement' => $achievementStatuses[HomeAchievement::class] ?? null,
            'leisureAchievement' => $achievementStatuses[LeisureAchievement::class] ?? null,
            'moneyAchievement' => $achievementStatuses[MoneyAchievement::class] ?? null,
            'workAchievement' => $achievementStatuses[WorkAchievement::class] ?? null,
            'personalGrowthAchievement' => $achievementStatuses[PersonalGrowthAchievement::class] ?? null,
        ]);
    }
}