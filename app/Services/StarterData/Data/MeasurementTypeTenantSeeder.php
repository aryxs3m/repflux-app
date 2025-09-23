<?php

namespace App\Services\StarterData\Data;

use App\Models\MeasurementType;
use App\Models\Tenant;

abstract class MeasurementTypeTenantSeeder
{
    public static function seed(Tenant $tenant): void
    {
        $lines = explode("\n", file_get_contents(storage_path('tenant_seeders/measurement_types.csv')));
        array_shift($lines);
        $lines = array_filter($lines);

        MeasurementType::query()->insert(array_map(function ($line) use ($tenant) {
            return [
                'tenant_id' => $tenant->id,
                'name' => __('seeder.'.$line),
            ];
        }, $lines));
    }
}
