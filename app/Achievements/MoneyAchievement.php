<?php

namespace App\Achievements;

use App\User;
use Assada\Achievements\Achievement;


class MoneyAchievement extends Achievement
{
    /**
     * Class Registered
     *
     * @package App\Achievements
     */
    public $name = "Money pin";
    public $slug = "Money-pin";
    public $description = "Felicidades! tienes tu pin de dinero!";
    public $points = 1;
}
