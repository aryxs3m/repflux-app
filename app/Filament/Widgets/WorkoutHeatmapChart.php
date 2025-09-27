<?php

namespace App\Filament\Widgets;

use App\Filament\Widgets\DTO\HeatmapSeriesResult;
use App\Services\Settings\Tenant;
use DateTime;
use DB;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Contracts\View\View;
use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;

class WorkoutHeatmapChart extends ApexChartWidget
{
    /**
     * Chart Id
     */
    protected static ?string $chartId = 'workoutHeatmapChart';

    protected function getHeading(): null|string|Htmlable|View
    {
        return __('pages.workouts.widgets.heatmap_chart.title');
    }

    protected int|string|array $columnSpan = 'full';

    /**
     * @SuppressWarnings(PHPMD) FIXME: if you can do better, pls fix this :)
     */
    protected function getSeries(): array
    {
        $data = [];

        /** @var HeatmapSeriesResult[] $results */
        $results = DB::select("
            SELECT
                CONCAT(YEAR(workout_at), ' ', MONTH(workout_at)) workout_at_month,
                DAY(workout_at) workout_at_day,
                SUM(calc_total_weight) weight_sum
            FROM
                workouts
            WHERE
                tenant_id = :tenant
                AND
                workout_at > DATE_SUB(NOW(),INTERVAL 1 YEAR)
            GROUP BY
                workout_at_month,
                workout_at_day
            ORDER BY
                workout_at_month,
                workout_at_day;", ['tenant' => Tenant::getTenant()->id]);

        // Move data to the "$data" array in a different format, fix missing values
        $lastMonth = null;
        $lastDay = null;

        foreach ($results as $result) {
            // Add missing days to the last month's series
            if ($lastMonth !== null && $lastMonth != $result->workout_at_month) {
                for ($i = $lastDay + 1; $i <= 31; $i++) {
                    $data[$lastMonth]['data'][] = [$i, 0];
                }
            }

            if ($lastMonth == null || $lastMonth != $result->workout_at_month) {
                $lastDay = 0;
            }

            // Add missing values before the first day of the current month (if any)
            for ($i = $lastDay + 1; $i < $result->workout_at_day; $i++) {
                $data[$result->workout_at_month]['data'][] = [$i, 0];
            }

            $data[$result->workout_at_month]['data'][] = [$result->workout_at_day, $result->weight_sum];

            $lastMonth = $result->workout_at_month;
            $lastDay = $result->workout_at_day;
        }

        // If lastMonth is null, then there is no workout data in the database and we should not process further
        if ($lastMonth === null) {
            return $data;
        }

        // Add missing days to the last month series
        for ($i = $lastDay + 1; $i <= 31; $i++) {
            $data[$lastMonth]['data'][] = [$i, 0];
        }

        // Add month names
        foreach (array_keys($data) as $monthIndex) {
            $data[$monthIndex]['name'] = DateTime::createFromFormat('!Y m', $monthIndex)
                ->format('Y M');
        }

        return $data;
    }

    /**
     * Chart options (series, labels, types, size, animations...)
     * https://apexcharts.com/docs/options
     */
    protected function getOptions(): array
    {
        $this->getSeries();

        return [
            'chart' => [
                'toolbar' => [
                    'show' => false,
                ],
                'type' => 'heatmap',
                'height' => 300,
            ],
            'grid' => [
                'show' => false,
            ],
            'plotOptions' => [
                'heatmap' => [
                    'useFillColorAsStroke' => true,
                    /*                    'colorScale' => [
                        'ranges' => [
                            [
                                'from' => 0,
                                'to' => 0,
                                'color' => '#f59e0b',
                                'name' => 'Weight',
                            ],
                        ],
                        'min' => 10,
                    ],*/
                ],
            ],
            'series' => array_values($this->getSeries()),
            'xaxis' => [
                'type' => 'category',
                'labels' => [
                    'style' => [
                        'fontFamily' => 'inherit',
                    ],
                ],
            ],
            'yaxis' => [
                'labels' => [
                    'style' => [
                        'fontFamily' => 'inherit',
                    ],
                ],
            ],
            'dataLabels' => [
                'enabled' => false,
            ],
            'colors' => ['#f59e0b'],
        ];
    }
}
