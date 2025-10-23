<?php

namespace App\Filament\Resources\MeasurementResource\Widgets;

use App\Filament\Resources\MeasurementTypeResource\BodyMeasurementType;
use App\Models\Measurement;
use App\Models\MeasurementType;
use App\Services\Data\BodyMeasurementService;
use App\Services\Settings\Tenant;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class BRIStat extends StatsOverviewWidget
{
    protected ?string $pollingInterval = null;

    protected function getStats(): array
    {
        return [
            $this->getBri(),
        ];
    }

    protected function getBri(): Stat
    {
        $stat = Stat::make('Body Roundness Index', 'N/A');

        $height = auth()->user()->height;

        $wc = app(BodyMeasurementService::class)
            ->getLastMeasurement(BodyMeasurementType::WAIST);

        if ($wc === null) {
            return $stat
                ->description('Missing waist measurement.');
        }

        if ($height === null) {
            return $stat
                ->description('Missing height measurement.');
        }

        $wc = $wc->value;

        $stat->value(Tenant::numberFormat(364.2 - 365.5 * sqrt(1 - pow($wc / (2 * pi()), 2) / pow(0.5 * $height, 2))));

        return $stat;
    }
}
