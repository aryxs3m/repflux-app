<?php

namespace App\Filament\Resources\ProgressionResource\Widgets;

use App\Models\Record;
use App\Models\RecordType;
use App\Models\Weight;
use Filament\Support\RawJs;
use Filament\Widgets\ChartWidget;

class RecordTypeProgressionChart extends ChartWidget
{
    public ?RecordType $record = null;

    protected ?string $heading = 'Max Weight Progression (Last 30 Sets)';

    protected int | string | array $columnSpan = 'full';
    protected ?string $maxHeight = '200px';

    protected function getData(): array
    {
        $weight = Record::query()
            ->selectRaw('*, MAX(weight) as mweight')
            ->join('record_sets', 'records.record_set_id', '=', 'record_sets.id')
            ->where('record_sets.user_id', auth()->id())
            ->where('record_sets.record_type_id', $this->record->id)
            ->groupBy('record_sets.id')
            ->orderBy('record_sets.set_done_at', 'desc')
            ->limit(30)
            ->get()
            ->pluck('weight', 'set_done_at')
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
