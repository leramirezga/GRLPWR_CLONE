<?php

namespace App\Achievements;


use Assada\Achievements\Achievement;

class HealthAchievement extends Achievement
{
    /**
     * Class Registered
     *
     * @package App\Achievements
     */
    public $name = "Health pin";
    public $slug = "Health-pin";
    public $description = "Felicidades! tienes tu pin de salud!";
    public $points = 1;

}
