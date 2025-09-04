<?php

namespace App\Filament\Resources\MeasurementResource\Widgets;

use App\Models\Measurement;
use App\Models\MeasurementType;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class MeasurementStats extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        $stats = [];
        foreach (MeasurementType::all() as $item) {
            $stat = $this->getStatWidgetForType($item);

            if (!$stat) {
                continue;
            }

            $stats[] = $stat;
        }

        return $stats;
    }

    protected function getStatWidgetForType(MeasurementType $measurementType): ?Stat
    {
        $lastMeasurement = Measurement::query()
            ->where('user_id', auth()->id())
            ->where('measurement_type_id', $measurementType->id)
            ->orderBy('id', 'desc')
            ->limit(1)
            ->first();

        if (!$lastMeasurement) {
            return null;
        }

        return Stat::make(
            $measurementType->name,
            $lastMeasurement->id,
        )->chart();
    }
}
