<?php
declare(strict_types=1);

namespace App\Achievements;

use App\User;
use Assada\Achievements\Achievement;
use Assada\Achievements\Model\AchievementProgress;

/**
 * Class Registered
 *
 * @package App\Achievements
 */
class MonthsTrained extends Achievement
{
    /*
     * The achievement name
     */
    public $name = 'MonthsTrained';

    /*
     * A small description for the achievement
     */
    public $description = 'Congratulations! you have your first month achievement';
    public $points = 999999999; //this achivement is never unlocked

    public function whenProgress($progress)
    {
        $user = User::find($progress->achiever_id);
        $points = AchievementProgress::where('achievement_id', env('RECORD_MONTHS_TRAINED_ACHIEVEMENT_ID'))
            ->where('achiever_id', $user->id)
            ->value('points');
        if (!$points || $progress->points > $points) {
            $user->addProgress(new RecordMonthsTrained());
        }
    }
}
