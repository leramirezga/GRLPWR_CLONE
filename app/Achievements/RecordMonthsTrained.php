<?php
declare(strict_types=1);

namespace App\Achievements;

use Assada\Achievements\Achievement;

/**
 * Class Registered
 *
 * @package App\Achievements
 */
class RecordMonthsTrained extends Achievement
{
    /*
     * The achievement name
     */
    public $name = 'RecordMonthsTrained';

    /*
     * A small description for the achievement
     */
    public $description = '';

    public $points = 999999999; //this achivement is never unlocked
}
