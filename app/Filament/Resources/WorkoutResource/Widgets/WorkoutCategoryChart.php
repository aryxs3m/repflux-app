<?php

namespace App\Filament\Resources\WorkoutResource\Widgets;

use App\Models\RecordCategory;
use App\Models\RecordSet;
use App\Models\Workout;
use Carbon\Carbon;
use Filament\Support\RawJs;
use Filament\Widgets\ChartWidget;
use Illuminate\Contracts\Support\Htmlable;

class WorkoutCategoryChart extends ChartWidget
{
    public ?Workout $record = null;

    public function getHeading(): string|Htmlable|null
    {
        return __('pages.workouts.widgets.category.title');
    }

    protected function getData(): array
    {
        if ($this->record === null) {
            $recordSets = RecordSet::query()
                ->where('user_id', auth()->id())
                ->whereBetween('set_done_at', [
                    Carbon::now()->startOfWeek()->toDateString(),
                    Carbon::now()->endOfWeek()->toDateString(),
                ])
                ->get();
        } else {
            $recordSets = $this->record->recordSets;
        }

        $sets = $recordSets->pluck('recordType.record_category_id')->toArray();
        $types = RecordCategory::query()->pluck('name', 'id')->toArray();
        $data = [];

        foreach ($types as $catId => $catName) {
            $data[$catName] = array_count_values($sets)[$catId] ?? 0;
        }

        return [
            'datasets' => [
                [
                    'label' => __('pages.workout.title'),
                    'data' => array_values($data),
                    'fill' => true,
                    'backgroundColor' => 'rgba(255, 99, 132, 0.2)',
                    'borderColor' => 'rgb(255, 99, 132)',
                    'pointBackgroundColor' => 'rgb(255, 99, 132)',
                    'pointBorderColor' => '#fff',
                    'pointHoverBackgroundColor' => '#fff',
                    'pointHoverBorderColor' => 'rgb(255, 99, 132)',
                ],
            ],
            'labels' => array_keys($data),
        ];
    }

    protected function getOptions(): array|RawJs|null
    {
        return [
            'elements' => [
                'line' => [
                    'borderWidth' => 3,
                ],
            ],
            'scales' => [
                'r' => [
                    'angleLines' => [
                        'color' => '#ffffff40',
                    ],
                    'grid' => [
                        'color' => '#ffffff20',
                    ],
                    'ticks' => [
                        'display' => false,
                    ],
                ],
                'x' => [
                    'display' => false,
                ],
                'y' => [
                    'display' => false,
                ],
            ],
            'plugins' => [
                'legend' => [
                    'display' => false,
                ],
            ],
        ];
    }

    protected function getType(): string
    {
        return 'radar';
    }
}
