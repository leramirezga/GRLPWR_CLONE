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
class WeeksTrained extends Achievement
{
    /*
     * The achievement name
     */
    public $name = 'WeeksTrained';
    /*
     * A small description for the achievement
     */
    public $description = 'Congratulations! you have increase your strike of weeks trained';
    public $points = 999999999; //this achivement is never unlocked

    public function whenProgress($progress)
    {
        if(!$progress->points){
            return;
        }
        $user = User::find($progress->achiever_id);
        if($progress->points % 4  == 0){
            $user->addProgress(new MonthsTrained());
        }
        $points =  AchievementProgress::where('achievement_id', env('RECORD_WEEKS_TRAINED_ACHIEVEMENT_ID'))
            ->where('achiever_id', $user->id)
            ->value('points');
        if(!$points || $progress->points > $points){
            $user->addProgress(new RecordWeeksTrained());
        }
    }
}
