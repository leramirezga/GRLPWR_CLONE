<?php

namespace App\Achievements;

use App\User;
use Assada\Achievements\Achievement;


class FamilyAndFriendsAchievement extends Achievement
{
    /**
     * Class Registered
     *
     * @package App\Achievements
     */
    public $name = "Family and friends pin";
    public $slug = "Family-and-friends-pin";
    public $description = "Felicidades! tienes tu pin de familia y amigos";

}
