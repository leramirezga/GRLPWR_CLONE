<?php

namespace App\Jobs;

use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ClearAssistedAchievement
{
    public function __construct()
    {}
    /**
     * This job clears the assisted class achievement progress for all users to start a new week progress
     *
     * @return void
     */
    public function __invoke(): void
    {
        Log::info('Cleaning the assisted class achievement progress');
        DB::transaction(function () {
            $achieverIds = DB::table('achievement_progress')
                ->where('achievement_id', env('ASSISTED_TO_CLASS_ACHIEVEMENT_ID'))
                ->whereNull('unlocked_at')
                ->pluck('achiever_id');
            if ($achieverIds && $achieverIds->isNotEmpty()) {
                DB::table('achievement_progress')
                    ->whereIn('achievement_id', [env('WEEKS_TRAINED_ACHIEVEMENT_ID'), env('MONTHS_TRAINED_ACHIEVEMENT_ID')])
                    ->whereIN('achiever_id', $achieverIds)
                    ->update(['points' => 0]);
            }
            DB::table('achievement_progress')->where('achievement_id', env('ASSISTED_TO_CLASS_ACHIEVEMENT_ID'))
                ->update(['points' => 0, 'unlocked_at' => null]);
        });
        Log::info('Successfully cleared assisted class achievement progress');
    }
}
