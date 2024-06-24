<?php

namespace App\Achievements;

use App\User;
use Assada\Achievements\Achievement;


class WorkAchievement extends Achievement
{
    /**
     * Class Registered
     *
     * @package App\Achievements
     */
    public $name = "Work pin";
    public $slug = "Work-pin";
    public $description = "Felicidades! tienes tu pin de trabajo!";
    public $points = 1;
}
