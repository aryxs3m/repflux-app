<?php

namespace App\Services\StarterData;

use App\Models\Tenant;
use App\Services\StarterData\Data\MeasurementTypeTenantSeeder;
use App\Services\StarterData\Data\RecordCategoryTenantSeeder;
use App\Services\StarterData\Data\RecordTypeTenantSeeder;

class StarterDataService
{
    public function seed(Tenant $tenant): void
    {
        RecordCategoryTenantSeeder::seed($tenant);
        MeasurementTypeTenantSeeder::seed($tenant);
        RecordTypeTenantSeeder::seed($tenant);
    }
}
