<?php

namespace App\Services\StarterData\Data;

use App\Models\RecordCategory;
use App\Models\RecordType;
use App\Models\Tenant;
use App\Services\StarterData\CsvSeederBase;
use Illuminate\Support\Facades\Cache;

abstract class RecordTypeTenantSeeder extends CsvSeederBase
{
    public static function seed(Tenant $tenant): void
    {
        $categories = RecordCategory::query()
            ->where('tenant_id', $tenant->id)
            ->get()
            ->pluck('id', 'name')->toArray();

        RecordType::query()->insert(array_map(function ($line) use ($tenant, $categories) {
            $line['record_category_id'] = $categories[$line['category']];
            $line['tenant_id'] = $tenant->id;
            unset($line['category']);
            unset($line['exercise_type']);

            return $line;
        }, self::getCSV('tenant_seeders/record_types.csv')));
    }
}
