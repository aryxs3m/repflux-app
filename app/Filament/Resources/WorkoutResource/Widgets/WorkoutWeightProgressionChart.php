<?php

namespace App\Filament\Resources\WorkoutResource\Widgets;

use App\Models\Workout;
use App\Services\Settings\Tenant;
use Carbon\Carbon;
use Filament\Support\RawJs;
use Filament\Widgets\ChartWidget;
use Illuminate\Contracts\Support\Htmlable;

class WorkoutWeightProgressionChart extends ChartWidget
{
    protected ?string $heading = '';
    protected ?string $pollingInterval = null;

    public ?Workout $record = null;

    public function getHeading(): string|Htmlable|null
    {
        return 'Last 10 similar workout moved weight';

        // return __('pages.workouts.widgets.weight_progression');
    }

    protected function getData(): array
    {
        $weight = \DB::select('
            select workout_at, calc_total_weight
            from workouts
            where
                tenant_id = ?
                and
                calc_dominant_category = ?
            order by workout_at
            limit 30', [Tenant::getTenant()->id, $this->record->calc_dominant_category]);

        $keys = array_map(fn ($date) => Carbon::parse($date)->toFormattedDateString(), array_column($weight, 'workout_at'));
        $values = array_column($weight, 'calc_total_weight');

        return [
            'datasets' => [
                [
                    'label' => __('pages.progression.widgets.weight'),
                    'data' => $values,
                ],
            ],
            'labels' => $keys,
        ];
    }

    protected function getOptions(): RawJs
    {
        $weightUnit = Tenant::getWeightUnitLabel();

        return RawJs::make(<<<JS
            {
                plugins: {
                    legend: {
                        display: false,
                    },
                },
                scales: {
                    y: {
                        ticks: {
                            callback: (value) => value + ' $weightUnit',
                        },
                    },
                },
            }
        JS);
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
