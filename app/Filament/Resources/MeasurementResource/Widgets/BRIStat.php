<?php

namespace App\Filament\Resources\MeasurementResource\Widgets;

use App\Filament\Resources\MeasurementTypeResource\BodyMeasurementType;
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

        /** @var BodyMeasurementService $bms */
        $bms = app(BodyMeasurementService::class);

        $height = auth()->user()->height;
        $wc = $bms->getLastMeasurement(BodyMeasurementType::WAIST);

        if ($wc === null) {
            return $stat
                ->description('Missing waist measurement.');
        }

        if ($height === null) {
            return $stat
                ->description('Missing height measurement.');
        }

        $wc = $wc->value;
        $bri = $bms->getBRI($wc, $height);

        $stat->value(Tenant::numberFormat($bri));
        $stat->description($bms->getBRICategory($bri)->getLabel());

        return $stat;
    }
}
