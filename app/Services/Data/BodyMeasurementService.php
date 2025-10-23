<?php

namespace App\Services\Data;

use App\Filament\Resources\MeasurementTypeResource\BodyMeasurementType;
use App\Models\Measurement;
use App\Services\Settings\Tenant;

class BodyMeasurementService {
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
}
