<?php

namespace App\Observers;

use App\Models\Record;
use App\Services\Workout\WorkoutService;
use Exception;

class WorkoutUpdaterObserver
{
    /**
     * @throws Exception
     */
    protected function callWorkoutService(Record $record): void
    {
        if ($record->recordSet->workout === null) {
            return;
        }

        app(WorkoutService::class)->calculateValues($record->recordSet->workout);
    }

    /**
     * @throws Exception
     */
    public function created(Record $record): void
    {
        $this->callWorkoutService($record);
    }

    /**
     * @throws Exception
     */
    public function updated(Record $record): void
    {
        $this->callWorkoutService($record);
    }

    /**
     * @throws Exception
     */
    public function deleted(Record $record): void
    {
        $this->callWorkoutService($record);
    }

    /**
     * @throws Exception
     */
    public function restored(Record $record): void
    {
        $this->callWorkoutService($record);
    }
}
