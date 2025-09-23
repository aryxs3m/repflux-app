<?php

namespace App\Services\StarterData\Data;

use App\Models\RecordCategory;
use App\Models\RecordType;
use App\Models\Tenant;
use Illuminate\Support\Facades\Cache;

abstract class RecordTypeTenantSeeder
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
        }, self::getData()));
    }

    protected static function getData(): array
    {
        return Cache::remember('app-record-type-seeder-data', 600, function () {
            $types = [];
            $file = fopen(storage_path('tenant_seeders/record_types.csv'), 'r');
            $headers = fgetcsv($file);

            while (! feof($file)) {
                $row = fgetcsv($file);
                if (empty($row)) {
                    continue;
                }

                $types[] = array_combine($headers, $row);
            }

            fclose($file);

            return $types;
        });
    }
}
