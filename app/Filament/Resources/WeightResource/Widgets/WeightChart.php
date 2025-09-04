<?php

namespace App\Filament\Resources\WeightResource\Widgets;

use App\Models\Weight;
use Filament\Support\RawJs;
use Filament\Widgets\ChartWidget;

class WeightChart extends ChartWidget
{
    protected ?string $heading = 'Weight Chart';

    protected int | string | array $columnSpan = 'full';
    protected ?string $maxHeight = '200px';

    protected function getData(): array
    {
        $weight = Weight::query()
            ->where('user_id', auth()->id())
            ->orderBy('measured_at', 'desc')
            ->limit(30)
            ->get()
            ->pluck('weight', 'measured_at')
            ->toArray();

        $keys = array_reverse(array_map(fn ($date) => date('M d', strtotime($date)), array_keys($weight)));
        $values = array_reverse(array_values($weight));

        return [
            'datasets' => [
                [
                    'label' => 'Weight',
                    'data' => $values,
                ],
            ],
            'labels' => $keys,
        ];
    }

    protected function getOptions(): RawJs
    {
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
                            callback: (value) => value + ' kg',
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
