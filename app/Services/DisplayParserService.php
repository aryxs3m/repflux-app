<?php

namespace App\Services;

use Spatie\Image\Image;

class DisplayParserService
{
    public function parseRectangle(string $filename, int $startX, int $startY, int $endX, int $endY)
    {
        $width = $endX - $startX;
        $height = $endY - $startY;

        Image::load($filename)
            ->contrast(75)
            ->brightness(-10)
            ->manualCrop(
                $width,
                $height,
                $startX,
                $startY
            )
            ->save('testcrop.jpg');
    }
}
