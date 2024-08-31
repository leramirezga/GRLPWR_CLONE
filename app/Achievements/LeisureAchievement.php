<?php

namespace App\Achievements;

use App\User;
use Assada\Achievements\Achievement;


class LeisureAchievement extends Achievement
{
    /**
     * Class Registered
     *
     * @package App\Achievements
     */
    public $name = "Leisure pin";
    public $slug = "Leisure-pin";
    public $description = "Felicidades! tienes tu pin de ocio!";
    public $points = 1;
}
