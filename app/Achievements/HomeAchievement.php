<?php

namespace App\Achievements;

use Assada\Achievements\Achievement;


class HomeAchievement extends Achievement
{
    /**
     * Class Registered
     *
     * @package App\Achievements
     */
    public $name = "Home pin";
    public $slug = "Home-pin";
    public $description = "Felicidades! tienes tu pin de hogar!";
    public $points = 1;
}
