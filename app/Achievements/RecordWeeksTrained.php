<?php
declare(strict_types=1);

namespace App\Achievements;

use Assada\Achievements\Achievement;

/**
 * Class Registered
 *
 * @package App\Achievements
 */
class RecordWeeksTrained extends Achievement
{
    /*
     * The achievement name
     */
    public $name = 'RecordWeeksTrained';

    /*
     * A small description for the achievement
     */
    public $description = '';

    public $points = 999999999; //this achivement is never unlocked
}
