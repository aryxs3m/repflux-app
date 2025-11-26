<?php

namespace App\Filament\Entries;

use App\Filament\Fields\StopwatchCast;
use Filament\Infolists\Components\TextEntry;

class StopwatchEntry extends TextEntry
{
    public function formatState(mixed $state): string
    {
        $stopwatchCast = new StopwatchCast;

        return $stopwatchCast->set($state);
    }
}
