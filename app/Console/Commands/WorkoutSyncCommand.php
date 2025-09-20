<?php

namespace App\Console\Commands;

use App\Models\RecordSet;
use App\Services\Workout\WorkoutService;
use Illuminate\Console\Command;

class WorkoutSyncCommand extends Command
{
    protected $signature = 'workout:sync';

    protected $description = 'Creates missing workout entities';

    public function handle(WorkoutService $service): void
    {
        $this->withProgressBar(RecordSet::all(), function (RecordSet $recordSet) use ($service) {
            try {
                $service->sync($recordSet);
            } catch (\Throwable $throwable) {
                $this->error($recordSet->id.': '.$throwable->getMessage());
            }
        });
    }
}
