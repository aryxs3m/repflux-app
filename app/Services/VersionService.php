<?php

namespace App\Services;

class VersionService
{
    public static function getVersion(): ?string
    {
        return \Cache::remember('version_string', 60, function () {
            if (file_exists('version.txt')) {
                return trim(file_get_contents('version.txt'));
            }

            if (file_exists(base_path('.git/HEAD'))) {
                return trim(file_get_contents(base_path('.git/HEAD')));
            }

            return null;
        });
    }
}
