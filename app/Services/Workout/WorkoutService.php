<?php

namespace App\Services\Workout;

use App\Models\Record;
use App\Models\RecordSet;
use App\Models\Workout;
use App\Services\Settings\TenantSettings;
use App\Services\Workout\Exceptions\MultipleWorkoutException;
use App\Services\Workout\Exceptions\WorkoutNotFoundException;
use Exception;
use Illuminate\Support\Collection;

/**
 * Handles Workout entity related features:
 *  - automatically adding sets
 */
class WorkoutService
{
    /**
     * @noinspection PhpConditionAlreadyCheckedInspection
     *
     * @throws Exception
     */
    public function sync(Workout|RecordSet $entity): void
    {
        if ($entity instanceof Workout) {
            $this->syncByWorkout($entity);

            return;
        }

        if ($entity instanceof RecordSet) {
            $this->syncByRecordSet($entity);

            return;
        }

        throw new Exception('Unknown entity type.');
    }

    protected function syncByWorkout(Workout $workout): void
    {
        RecordSet::query()
            ->whereBetween('set_done_at', [$workout->workout_at->startOfDay(), $workout->workout_at->endOfDay()])
            ->where('tenant_id', TenantSettings::getTenant()->id)
            ->where('user_id', auth()->user()->id)
            ->update(['workout_id' => $workout->id]);
    }

    /**
     * @throws WorkoutNotFoundException|MultipleWorkoutException
     */
    protected function syncByRecordSet(RecordSet $recordSet): void
    {
        $workout = Workout::query()
            ->where('tenant_id', $recordSet->tenant_id)
            ->whereBetween('workout_at', [$recordSet->set_done_at->startOfDay(), $recordSet->set_done_at->endOfDay()])
            // ->whereHas('user', fn ($query) => $query->where('id', auth()->user()->id))
            ->get();

        if ($workout->count() > 1) {
            throw new MultipleWorkoutException;
        }

        if ($workout->count() === 0) {
            $workout = Collection::make([Workout::query()->create([
                'workout_at' => $recordSet->set_done_at,
                'tenant_id' => $recordSet->tenant_id,
            ])]);
        }

        $recordSet->update(['workout_id' => $workout->first()->id]);
    }

    protected function calculateValues(Workout $workout): void {}

    public static function getPreviousWorkout(Workout $originalWorkout): ?Workout
    {
        return Workout::query()
            ->where('tenant_id', $originalWorkout->tenant_id)
            ->where('id', '<', $originalWorkout->id)
            ->orderBy('id', 'desc')
            ->first();
    }

    public static function countReps(Workout $workout): int
    {
        $reps = 0;

        foreach ($workout->recordSets as $set) {
            foreach ($set->records as $record) {
                $reps += $record->repeat_count;
            }
        }

        return $reps;
    }

    public static function countWeights(Workout $workout): int
    {
        $reps = 0;

        foreach ($workout->recordSets as $set) {
            /** @var Record $record */
            foreach ($set->records as $record) {
                $reps += $record->weight_with_base;
            }
        }

        return $reps;
    }
}
