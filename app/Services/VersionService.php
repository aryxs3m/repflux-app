<?php

namespace App\Services;

class VersionService
{
    public static function getCurrentBranch(): ?string
    {
        return file_get_contents(base_path('.git/HEAD')) ?? null;
    }
}
