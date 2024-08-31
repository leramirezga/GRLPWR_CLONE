<?php

namespace App\Achievements;

use App\User;
use Assada\Achievements\Achievement;


class LoveAchievement extends Achievement
{
    /**
     * Class Registered
     *
     * @package App\Achievements
     */
    public $name = "Love pin";
    public $slug = "Love-pin";
    public $description = "Felicidades! tienes tu pin de amor!";
    public $points = 1;
}
