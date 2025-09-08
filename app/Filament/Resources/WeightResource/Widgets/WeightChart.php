<?php

namespace App\Filament\Resources\WeightResource\Widgets;

use App\Models\Weight;
use App\Services\Settings\TenantSettings;
use Filament\Support\RawJs;
use Filament\Widgets\ChartWidget;
use Illuminate\Contracts\Support\Htmlable;

class WeightChart extends ChartWidget
{
    protected ?string $heading = 'Weight Chart';

    public function getHeading(): string|Htmlable|null
    {
        return __('pages.weight.widgets.weight_history');
    }

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
                    'label' => __('columns.weight'),
                    'data' => $values,
                ],
            ],
            'labels' => $keys,
        ];
    }

    protected function getOptions(): RawJs
    {
        $weightLabel = TenantSettings::getWeightUnitLabel();

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
                            callback: (value) => value + ' $weightLabel',
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
