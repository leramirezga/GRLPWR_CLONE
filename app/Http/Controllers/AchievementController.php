<?php

namespace App\Http\Controllers;

use Assada\Achievements\Model\AchievementProgress;
use Illuminate\Support\Env;
use Illuminate\Support\Traits\EnumeratesValues;


class AchievementController extends Controller
{
    public function showAchievements()
    {
        $achievements = AchievementProgress::where('achievement_id', env('WEEKS_TRAINED_ACHIEVEMENT_ID'))->with('achiever')->orderBy('points', 'desc')->take(10)->get();
        return view('cliente.weekAchievements', compact('achievements'));
    }
}
