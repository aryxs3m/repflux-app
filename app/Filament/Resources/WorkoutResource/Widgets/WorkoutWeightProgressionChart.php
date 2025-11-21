<?php

namespace App\Filament\Resources\WorkoutResource\Widgets;

use App\Models\Workout;
use App\Services\Settings\Tenant;
use Filament\Support\RawJs;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Collection;

class WorkoutWeightProgressionChart extends ChartWidget
{
    protected ?string $pollingInterval = null;

    public ?Workout $record = null;

    public ?string $filter = 'weekly';

    public function getHeading(): string|Htmlable|null
    {
        return __('pages.workouts.widgets.weight_progression.title');
    }

    protected function getFilters(): ?array
    {
        return [
            'daily' => __('pages.workouts.widgets.weight_progression.filters.daily'),
            'weekly' => __('pages.workouts.widgets.weight_progression.filters.weekly'),
            'halfyear' => __('pages.workouts.widgets.weight_progression.filters.halfyear'),
        ];
    }

    protected function getRawData(): Collection
    {
        $data = Trend::query(Workout::query()
            ->where('tenant_id', '=', Tenant::getTenant()->id)
        );

        switch ($this->filter) {
            case 'daily':
                $data = $data
                    ->between(
                        start: now()->subDays(30),
                        end: now()
                    )
                    ->perDay();
                break;
            case 'weekly':
                $data = $data
                    ->between(
                        start: now()->subMonths(),
                        end: now()
                    )
                    ->perWeek();
                break;
            case 'halfyear':
                $data = $data
                    ->between(
                        start: now()->subMonths(6),
                        end: now()
                    )
                    ->perMonth();
                break;
        }

        return $data->average('calc_total_weight');
    }

    protected function getData(): array
    {
        $data = $this->getRawData();
        $keys = $data->pluck('date')->toArray();
        $values = $data->pluck('aggregate');

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
