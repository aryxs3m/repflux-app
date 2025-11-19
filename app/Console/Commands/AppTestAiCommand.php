<?php

namespace App\Console\Commands;

use App\Services\AiService;
use App\Services\DisplayParserService;
use Illuminate\Console\Command;

class AppTestAiCommand extends Command
{
    protected $signature = 'app:test-ai';

    protected $description = 'Command description';

    public function handle(AiService $service, DisplayParserService $displayParserService): void
    {
        $displayParserService->parseDisplay('3dk.jpg');

        /*$displayParserService->parseRectangle(
            'IMG20250914133235.jpg',
            370, 740,
            780, 970
        );*/

        // TESSDATA_PREFIX=/home/aryxs3m/tmp/deskew/ tesseract cal.jpg - --oem 3 --psm 7 -c tessedit_char_whitelist=0123456789. -l ssd

        /*$result = $service->parseThreadmill('IMG20250914133235.jpg');
        dd($result);*/
    }
}
