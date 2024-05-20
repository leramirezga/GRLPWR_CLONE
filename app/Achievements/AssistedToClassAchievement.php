<?php
declare(strict_types=1);

namespace App\Achievements;

use App\User;
use Assada\Achievements\Achievement;

/**
 * Class Registered
 *
 * @package App\Achievements
 */
class AssistedToClassAchievement extends Achievement
{
    public $name = "Assisted to class";
    public $slug = "assisted-to-class";
    public $description = "You have trained for 3 days this week";
    public $points = 3;
    /*
     * Triggers whenever an Achiever unlocks this achievement
    */
    public function whenUnlocked($progress)
    {
        $user = User::find($progress->achiever_id);
        $user->addProgress(new WeeksTrained());
        //TODO Revisar logica para cuando el administrador le da por equivocacion asistio y lo cancela
    }
}
