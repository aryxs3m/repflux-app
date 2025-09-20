<?php

namespace App\Filament\Widgets;

use App\Models\Workout;
use App\Services\Settings\TenantSettings;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class LastWorkoutStats extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        $workout = Workout::query()
            ->where('tenant_id', TenantSettings::getTenant()->id)
            ->orderBy('workout_at', 'desc')
            ->limit(1)
            ->first();

        if ($workout === null) {
            return [];
        }

        return [
            Stat::make(__('pages.workouts.widgets.last_dominant_category'), $workout->dominantCategory->name),
            Stat::make(__('pages.workouts.widgets.last_total_weight'), $workout->calc_total_weight.' '.TenantSettings::getWeightUnitLabel()),
            Stat::make(__('pages.workouts.widgets.last_total_reps'), $workout->calc_total_reps),
        ];
    }
}
