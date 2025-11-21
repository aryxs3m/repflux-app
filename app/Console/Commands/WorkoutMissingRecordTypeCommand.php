<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\Workout;
use App\Notifications\MissingWorkoutRecordNotification;
use App\Services\Workout\WorkoutService;
use Illuminate\Console\Command;

class WorkoutMissingRecordTypeCommand extends Command
{
    protected $signature = 'app:workout-missing-record-type-notifier';

    protected $description = 'Missing record types notification';

    private int $notifyCount = 0;

    public function handle(WorkoutService $service): void
    {
        $this->line('Handling missing workout records notifications...');

        $workouts = Workout::query()
            ->whereBetween('created_at', [
                now()->subDay()->startOfDay(),
                now()->subDay()->endOfDay(),
            ]);

        $workouts->each(function (Workout $workout) use ($service) {
            $recordTypes = $service::getMissingRecords($workout);
            if ($recordTypes->isNotEmpty()) {
                $workout->tenant->users->each(function (User $user) use ($workout, $recordTypes) {
                    $this->notifyCount++;
                    $user->notify(new MissingWorkoutRecordNotification($workout, $recordTypes));
                }
                );
            }
        });

        $this->line('Notifications sent: '.$this->notifyCount);
    }
}
