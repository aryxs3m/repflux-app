<?php

namespace App\Services\ChartBuilder;

enum DatasetPointStyle: string
{
    case CIRCLE = 'circle';
    case CROSS = 'cross';
    case CROSS_ROT = 'crossRot';
    case DASH = 'dash';
    case LINE = 'line';
    case RECT = 'rect';
    case RECT_ROUNDED = 'rect_rounded';
    case RECT_ROT = 'rect_rot';
    case STAR = 'star';
    case TRIANGLE = 'triangle';
    case FALSE = 'false';
}
