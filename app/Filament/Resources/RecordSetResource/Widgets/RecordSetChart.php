<?php

namespace App\Filament\Resources\RecordSetResource\Widgets;

use App\Models\Record;
use App\Models\RecordSet;
use Filament\Support\RawJs;
use Filament\Widgets\ChartWidget;

class RecordSetChart extends ChartWidget
{
    public ?RecordSet $record = null;
    protected ?string $heading = 'Reps and weights';
    protected int | string | array $columnSpan = 'full';
    protected ?string $maxHeight = '200px';

    protected function getData(): array
    {
        $results = $this->record->records->toArray();

        return [
            'datasets' => [
                [
                    'label' => 'Repeats',
                    'data' => array_column($results, 'repeat_count'),
                    'backgroundColor' => '#eb403433',
                    'borderColor' => '#eb4034',
                ],
                [
                    'label' => 'Weight',
                    'data' => array_column($results, 'weight'),
                ],
            ],
            'labels' => array_column($results, 'repeat_index'),
        ];
    }

    protected function getOptions(): RawJs
    {
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
                            callback: (value) => (value + 1) + '. rep',
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
