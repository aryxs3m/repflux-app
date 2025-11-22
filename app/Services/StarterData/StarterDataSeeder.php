<?php

namespace App\Services\StarterData;

use App\Models\Tenant;

interface StarterDataSeeder
{
    public static function seed(Tenant $tenant): void;
}
