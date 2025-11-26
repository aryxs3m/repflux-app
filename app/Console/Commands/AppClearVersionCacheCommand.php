<?php

namespace App\Console\Commands;

use App\Services\VersionService;
use Illuminate\Console\Command;

class AppClearVersionCacheCommand extends Command
{
    protected $signature = 'app:clear-version-cache';

    protected $description = 'Empties the version cache';

    public function handle(): void
    {
        VersionService::clearCache();
        $this->line('Cleared cache.');
    }
}
