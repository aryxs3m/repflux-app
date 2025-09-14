<?php

namespace App\Console\Commands;

use App\Services\AiService;
use Illuminate\Console\Command;

class AppTestAiCommand extends Command
{
    protected $signature = 'app:test-ai';

    protected $description = 'Command description';

    public function handle(AiService $service): void
    {
        $result = $service->parseThreadmill('IMG20250914133235.jpg');
        dd($result);
    }
}
