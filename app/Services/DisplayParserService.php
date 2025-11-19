<?php

namespace App\Services;

use App\Services\DisplayParsing\TesseractParser;
use Illuminate\Support\Facades\Process;
use Spatie\Image\Image;

class DisplayParserService
{
    public function parseRectangle(string $filename, int $startX, int $startY, int $endX, int $endY)
    {
        $width = $endX - $startX;
        $height = $endY - $startY;

        Image::load($filename)
            ->manualCrop(
                $width,
                $height,
                $startX,
                $startY
            )
            ->contrast(75)
            ->brightness(-10)
            ->save('testcrop.jpg');
    }

    public function parseDisplay(string $filename)
    {
        self::deskew($filename);
        // TESSDATA_PREFIX=/home/aryxs3m/tmp/deskew/
        $tesseract = Process::run([
            'tesseract',
            $filename,
            '-',
            '--oem', '2',
            '--psm', '11',
            '-l', 'eng',
            'tsv'
        ]);

        $parsed = TesseractParser::parse($tesseract->output());
        dd($parsed->filterByConfidence(90));
    }

    protected function deskew(string $filename): void
    {
        // TODO
    }
}
