<?php

namespace App\Filament\Resources\RecordTypeResource;

use App\Utilities\HasDescription;
use Filament\Support\Contracts\HasLabel;

enum ExerciseType: string implements HasDescription, HasLabel
{
    case WEIGHT = 'weight';
    case CARDIO = 'cardio';
    case OTHER = 'other';
    case TIME = 'time';

    public function getLabel(): string
    {
        return __(sprintf('exercise.%s.label', $this->value));
    }

    public function getDescription(): string
    {
        return __(sprintf('exercise.%s.description', $this->value));
    }
}
