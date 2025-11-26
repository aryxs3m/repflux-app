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
        echo " Seeding database with RecordCategories...\n";
        RecordCategoryTenantSeeder::seed($tenant);

        echo " Seeding database with MeasurementTypes...\n";
        MeasurementTypeTenantSeeder::seed($tenant);

        echo " Seeding database with RecordTypes...\n";
        RecordTypeTenantSeeder::seed($tenant);
    }
}
