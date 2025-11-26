<?php

namespace App\Services\StarterData\Data;

use App\Filament\Resources\MeasurementTypeResource\BodyMeasurementType;
use App\Models\MeasurementType;
use App\Models\Tenant;
use App\Services\StarterData\CsvSeederBase;

abstract class MeasurementTypeTenantSeeder extends CsvSeederBase
{
    public static function seed(Tenant $tenant): void
    {
        MeasurementType::query()->insert(array_map(function ($row) use ($tenant) {
            return [
                'tenant_id' => $tenant->id,
                'name' => __('seeder.'.$row['name']),
                'measurement_type' => BodyMeasurementType::from($row['const']),
            ];
        }, self::getCSV('tenant_seeders/measurement_types.csv')));
    }
}
