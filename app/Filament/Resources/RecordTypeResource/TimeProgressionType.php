<?php

namespace App\Filament\Resources\RecordTypeResource;

use App\Utilities\HasDescription;
use Filament\Support\Contracts\HasLabel;

enum TimeProgressionType: string implements HasDescription, HasLabel
{
    case UP = 'up';
    case DOWN = 'down';

    public function getLabel(): string
    {
        return __(sprintf('time_progression.%s.label', $this->value));
    }

    public function getDescription(): string
    {
        return __(sprintf('time_progression.%s.description', $this->value));
    }
}
