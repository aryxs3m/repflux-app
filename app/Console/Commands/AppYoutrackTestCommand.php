<?php

namespace App\Console\Commands;

use App\Services\YouTrack;
use Illuminate\Console\Command;
use Illuminate\Http\Client\ConnectionException;

class AppYoutrackTestCommand extends Command
{
    protected $signature = 'app:youtrack-test';

    protected $description = 'Test YouTrack integration';

    /**
     * @throws ConnectionException
     */
    public function handle(YouTrack $youTrack): void
    {
        $youTrack->createIssue('Test 2', 'Test 2 feedback description. Is this readable?');
    }
}
