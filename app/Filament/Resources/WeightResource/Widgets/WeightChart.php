<?php

namespace App\Filament\Resources\WeightResource\Widgets;

use App\Models\Weight;
use App\Services\ChartBuilder\BaseChart;
use App\Services\ChartBuilder\Dataset;
use App\Services\ChartBuilder\DatasetFill;
use App\Services\Settings\Tenant;
use Filament\Support\RawJs;
use Filament\Widgets\ChartWidget;
use Illuminate\Contracts\Support\Htmlable;

class WeightChart extends ChartWidget
{
    protected ?string $pollingInterval = null;

    protected ?string $heading = 'Weight Chart';

    public function getHeading(): string|Htmlable|null
    {
        return __('pages.weight.widgets.weight_history');
    }

    protected int|string|array $columnSpan = 'full';

    protected ?string $maxHeight = '250px';

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

        $weightChart = BaseChart::make()
            ->addLabels($keys)
            ->addDataset(Dataset::make()
                ->setLabel(__('columns.weight'))
                ->setFill(DatasetFill::ORIGIN)
                ->addValues($values));

        if (auth()->user()->weight_target) {
            $weightChart->addDataset(Dataset::make()
                ->setLabel(__('columns.weight_target'))
                ->setBorderDash([5, 15])
                ->setBorderColor('#ffffff50')
                ->setPointStyle(false)
                ->addValues(array_fill(0, count($values), auth()->user()->weight_target)));
        }

        return $weightChart->toArray();
    }

    protected function getOptions(): RawJs
    {
        $weightLabel = Tenant::getWeightUnitLabel();

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
        return 'line';
    }
}
