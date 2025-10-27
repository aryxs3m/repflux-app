<?php

namespace App\Services\StarterData;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

abstract class CsvSeederBase
{
    protected static function getCSV(string $filePath): array
    {
        return Cache::tags(['seeder'])->remember(Str::slug($filePath), 600, function () use ($filePath) {
            $types = [];
            $file = fopen(storage_path($filePath), 'r');
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
