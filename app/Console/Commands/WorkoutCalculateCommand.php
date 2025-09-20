<?php

namespace App\Console\Commands;

use App\Models\Workout;
use App\Services\Workout\WorkoutService;
use Illuminate\Console\Command;

class WorkoutCalculateCommand extends Command
{
    protected $signature = 'workout:calculate';

    protected $description = 'Command description';

    public function handle(WorkoutService $service): void
    {
        $this->withProgressBar(Workout::all(), function (Workout $workout) use ($service) {
            $service->calculateValues($workout);
        });
    }
}
