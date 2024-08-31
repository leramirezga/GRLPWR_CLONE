<?php

namespace App\Achievements;

use Assada\Achievements\Achievement;


class PersonalGrowthAchievement extends Achievement
{
    /**
     * Class Registered
     *
     * @package App\Achievements
     */
    public $name = "Personal Growth pin";
    public $slug = "Personal-Growth-pin";
    public $description = "Felicidades! tienes tu pin de desarrollo personal!";
    public $points = 1;
}
