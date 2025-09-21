<?php

namespace App\Filament\Resources\MeasurementResource\Widgets;

use App\Models\Measurement;
use App\Models\MeasurementType;
use App\Services\Settings\Tenant;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class MeasurementStats extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return \Cache::tags(['measurement-stats'])->remember(auth()->id().'-measurement-stats', 10, function () {
            $stats = [];
            foreach (MeasurementType::all() as $item) {
                $stat = $this->getStatWidgetForType($item);

                if (! $stat) {
                    continue;
                }

                $stats[] = $stat;
            }

            return $stats;
        });
    }

    protected function getStatWidgetForType(MeasurementType $measurementType): ?Stat
    {
        $measurements = Measurement::query()
            ->where('user_id', auth()->id())
            ->where('measurement_type_id', $measurementType->id)
            ->orderBy('measured_at', 'desc')
            ->limit(10)
            ->get();

        if ($measurements->isEmpty()) {
            return null;
        }

        $latestMeasurement = $measurements->first();
        $allMeasurements = $measurements->reverse()->pluck('value')->toArray();

        $stat = Stat::make($measurementType->name, $latestMeasurement->value.' '.Tenant::getLengthUnitLabel())
            ->chart($allMeasurements)
            ->description($latestMeasurement->measured_at->diffForHumans());

        return $stat;
    }
}
