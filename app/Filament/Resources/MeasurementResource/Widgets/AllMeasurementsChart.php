<?php

namespace App\Filament\Resources\MeasurementResource\Widgets;

use Filament\Widgets\ChartWidget;

class AllMeasurementsChart extends ChartWidget
{
    protected ?string $heading = 'All Measurements Chart';

    protected int | string | array $columnSpan = 'full';

    protected function getData(): array
    {
        $query = \DB::select(<<<SQL
select
    date(measured_at) AS `date`,
    measurement_type_id AS `type`,
    avg(value) AS `value`
from
    measurements
group by
    date(measured_at),
    measurement_type_id;
SQL);

        return [
            'datasets' => [
                [
                    'label' => 1,
                    'data' => [1,2,3,4,5,6,7],
                ],
                [
                    'label' => 2,
                    'data' => [1,2,3,4,5,6,7],
                ],
                [
                    'label' => 3,
                    'data' => [1,2,3,4,5,6,7],
                ],
                [
                    'label' => 4,
                    'data' => [1,2,3,4,5,6,7],
                ],
            ],
            'labels' => [1, 2, 3, 4, 5, 6, 7, 8],
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
