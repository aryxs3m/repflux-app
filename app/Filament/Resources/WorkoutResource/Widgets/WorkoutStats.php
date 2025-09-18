<?php

namespace App\Filament\Resources\WorkoutResource\Widgets;

use App\Models\Workout;
use App\Services\Settings\TenantSettings;
use App\Services\Workout\WorkoutService;
use Filament\Support\Icons\Heroicon;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class WorkoutStats extends StatsOverviewWidget
{
    public Workout $record;

    protected ?Workout $previous = null;

    protected function getStats(): array
    {
        $this->previous = WorkoutService::getPreviousWorkout($this->record);

        return [
            $this->makeExercisesStat(),
            $this->makeRepsStat(),
            $this->makeWeightStat(),
        ];
    }

    protected function makeTrend(Stat $stat, $previous, $suffix = '')
    {
        $diff = $stat->getValue() - $previous;
        $stat->value($stat->getValue().' '.$suffix);

        if ($diff === 0) {
            return;
        }

        if ($diff > 0) {
            $stat->icon(Heroicon::ArrowTrendingUp);
            $stat->color('success');
        } else {
            $stat->icon(Heroicon::ArrowTrendingDown);
            $stat->color('danger');
        }

        $stat->description(sprintf(
            'Legutóbbi: %s %s',
            $previous,
            $suffix
        ));
    }

    protected function makeExercisesStat(): Stat
    {
        $stat = Stat::make(__('pages.workouts.widgets.exercises'), $this->record->recordSets->count());

        if ($this->previous) {
            $this->makeTrend($stat, $this->previous->recordSets->count());
        }

        return $stat;
    }

    protected function makeRepsStat(): Stat
    {
        $stat = Stat::make(__('pages.workouts.widgets.total_reps'), WorkoutService::countReps($this->record));

        if ($this->previous) {
            $this->makeTrend($stat, WorkoutService::countReps($this->previous), __('columns.reps_short'));
        }

        return $stat;
    }

    protected function makeWeightStat(): Stat
    {
        $stat = Stat::make(__('pages.workouts.widgets.total_weight'), WorkoutService::countWeights($this->record));

        if ($this->previous) {
            $this->makeTrend($stat, WorkoutService::countWeights($this->previous), TenantSettings::getWeightUnitLabel());
        }

        return $stat;
    }
}
