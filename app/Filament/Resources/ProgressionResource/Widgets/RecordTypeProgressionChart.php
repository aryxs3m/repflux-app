<?php

namespace App\Filament\Resources\ProgressionResource\Widgets;

use App\Models\RecordType;
use App\Services\Settings\Tenant;
use Carbon\Carbon;
use Filament\Support\RawJs;
use Filament\Widgets\ChartWidget;
use Illuminate\Contracts\Support\Htmlable;

class RecordTypeProgressionChart extends ChartWidget
{
    public ?RecordType $record = null;

    public function getHeading(): string|Htmlable|null
    {
        return __('pages.progression.widgets.weight_progression');
    }

    protected int|string|array $columnSpan = 'full';

    protected ?string $maxHeight = '200px';

    protected function getData(): array
    {
        $weight = \DB::select('
            select set_done_at, MAX(weight) + record_types.base_weight as mweight
            from `records`
                inner join `record_sets` on `records`.`record_set_id` = `record_sets`.`id`
                inner join `record_types` on record_sets.record_type_id = record_types.id
            where `record_sets`.`user_id` = ?
              and `record_sets`.`record_type_id` = ?
            group by `record_sets`.`id`
            order by set_done_at
            limit 30', [auth()->id(), $this->record->id]);

        $keys = array_map(fn ($date) => Carbon::parse($date)->toFormattedDateString(), array_column($weight, 'set_done_at'));
        $values = array_column($weight, 'mweight');

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
