<?php

namespace App\Observers;

use App\Models\RecordSet;
use App\Services\Workout\WorkoutService;
use Exception;

class WorkoutGeneratorObserver
{
    /**
     * @throws Exception
     */
    public function created(RecordSet $recordSet): void
    {
        $this->callWorkoutService($recordSet);
    }

    /**
     * @throws Exception
     */
    public function deleted(RecordSet $recordSet): void
    {
        $this->callWorkoutService($recordSet);
    }

    /**
     * @throws Exception
     */
    public function restored(RecordSet $recordSet): void
    {
        $this->callWorkoutService($recordSet);
    }

    /**
     * @throws Exception
     */
    protected function callWorkoutService(RecordSet $recordSet): void
    {
        app(WorkoutService::class)->sync($recordSet);
    }
}
