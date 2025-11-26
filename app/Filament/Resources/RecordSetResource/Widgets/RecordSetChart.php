<?php

namespace App\Filament\Resources\RecordSetResource\Widgets;

use App\Models\RecordSet;
use App\Services\Settings\Tenant;
use Filament\Support\RawJs;
use Filament\Widgets\ChartWidget;
use Illuminate\Contracts\Support\Htmlable;

class RecordSetChart extends ChartWidget
{
    protected ?string $pollingInterval = null;

    public ?RecordSet $record = null;

    public function getHeading(): string|Htmlable|null
    {
        return __('pages.record_sets.widget.reps_and_weights');
    }

    protected int|string|array $columnSpan = 'full';

    protected ?string $maxHeight = '400px';

    protected function getData(): array
    {
        $results = $this->record->records->toArray();

        return [
            'datasets' => [
                [
                    'label' => __('pages.record_sets.widget.repeats'),
                    'data' => array_column($results, 'repeat_count'),
                    'backgroundColor' => '#eb403433',
                    'borderColor' => '#eb4034',
                ],
                [
                    'label' => __('pages.record_sets.widget.weight'),
                    'data' => array_column($results, 'weight_with_base'),
                ],
            ],
            'labels' => array_column($results, 'repeat_index'),
        ];
    }

    protected function getOptions(): RawJs
    {
        $repUnit = __('columns.reps_short');
        $weightUnit = Tenant::getWeightUnitLabel();

        return RawJs::make(<<<JS
            {
                indexAxis: 'y',
                plugins: {
                    legend: {
                        display: false,
                    },
                },
                scales: {
                    y: {
                        ticks: {
                            callback: (value) => (value + 1) + '. $repUnit',
                        },
                    },
                    x: {
                        ticks: {
                            callback: (value) => (value + 1) + ' $weightUnit',
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
