<?php

namespace App\Services\Data;

use App\Filament\Resources\MeasurementTypeResource\BodyMeasurementType;
use App\Models\Measurement;
use App\Services\Settings\Tenant;

class BodyMeasurementService
{
    public function getLastMeasurement(BodyMeasurementType $measurementType): ?Measurement
    {
        return Measurement::with('measurementType')
            ->where('user_id', auth()->id())
            ->where('tenant_id', Tenant::getTenant()->id)
            ->whereRelation('measurementType', 'measurement_type', $measurementType->value)
            ->orderBy('measured_at', 'desc')
            ->limit(1)
            ->get()
            ->first();
    }

    public function getBRI(int $wc, int $height): float
    {
        return 364.2 - 365.5 * sqrt(1 - pow($wc / (2 * pi()), 2) / pow(0.5 * $height, 2));
    }

    public function getBRICategory(float $briValue): BRICategory
    {
        if ($briValue >= 6.9) {
            return BRICategory::ROUND_HIGH_RISK;
        }

        if ($briValue >= 5.6) {
            return BRICategory::OVERWEIGHT;
        }

        if ($briValue >= 4.5) {
            return BRICategory::NORMAL;
        }

        if ($briValue >= 3.4) {
            return BRICategory::NORMAL_LEAN;
        }

        return BRICategory::LEAN;
    }
}
