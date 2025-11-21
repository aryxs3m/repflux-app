<?php

namespace App\Services\Workout;

use App\Models\RecordSet;
use App\Models\RecordType;
use App\Models\Workout;
use App\Services\Settings\Tenant;
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
            ->where('tenant_id', Tenant::getTenant()->id)
            ->where('user_id', auth()->user()->id)
            ->update(['workout_id' => $workout->id]);

        $this->calculateValues($workout);
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
        $this->calculateValues($workout->first());
    }

    public function calculateValues(Workout $workout): void
    {
        $totalReps = 0;
        $totalWeight = 0;
        $types = [];
        $categories = [];

        foreach ($workout->recordSets as $set) {
            foreach ($set->records as $record) {
                $totalReps += $record->repeat_count;
                $totalWeight += $record->weight_with_base;
            }

            $types[] = $set->record_type_id;
            $categories[] = $set->recordType->record_category_id;
        }

        $categoriesCount = array_count_values($categories);
        arsort($categoriesCount);
        if (! empty($categoriesCount)) {
            $dominant = array_keys($categoriesCount)[0];
            $workout->calc_dominant_category = $dominant;
        }

        $workout->calc_total_reps = $totalReps;
        $workout->calc_total_weight = $totalWeight;
        $workout->calc_total_exercises = count(array_unique($types));

        $workout->save();
    }

    public static function getPreviousWorkout(Workout $originalWorkout): ?Workout
    {
        return Workout::query()
            ->where('tenant_id', $originalWorkout->tenant_id)
            ->where('id', '<', $originalWorkout->id)
            ->where('calc_dominant_category', '=', $originalWorkout->calc_dominant_category)
            ->orderBy('id', 'desc')
            ->first();
    }

    /**
     * @return Collection|RecordType[]
     *
     * @noinspection PhpDocSignatureInspection
     */
    public static function getMissingRecords(Workout $workout): Collection
    {
        $users = $workout->tenant->users->count();

        if ($users <= 1) {
            return Collection::make();
        }

        $count = array_count_values($workout->recordSets->pluck('record_type_id')->toArray());
        $ids = array_keys(array_filter($count, fn ($value) => $value < $users));

        return RecordType::query()->whereIn('id', $ids)->get();
    }
}
