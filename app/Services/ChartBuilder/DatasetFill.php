<?php

namespace App\Services\ChartBuilder;

enum DatasetFill: string
{
    case START = 'start';
    case END = 'end';
    case ORIGIN = 'origin';
    case DISABLED = 'false';
}
