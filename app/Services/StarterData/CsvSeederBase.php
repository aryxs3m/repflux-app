<?php

namespace App\Services\StarterData;

use Illuminate\Support\Facades\Cache;

abstract class CsvSeederBase {
    protected static function getCSV(string $filePath): array
    {
        return Cache::tags(['seeder'])->remember(md5($filePath), 600, function () use ($filePath) {
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
