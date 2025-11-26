<?php

namespace App\Services;

class VersionService
{
    public static function getVersion(): ?string
    {
        return \Cache::remember('version_string', 600, function () {
            if (file_exists(base_path('version.txt'))) {
                return trim(file_get_contents(base_path('version.txt')));
            }

            if (file_exists(base_path('.git/HEAD'))) {
                return trim(file_get_contents(base_path('.git/HEAD')));
            }

            return null;
        });
    }

    public static function clearCache(): void
    {
        \Cache::forget('version_string');
    }
}
