<?php

namespace App\Filament\Resources\RecordTypeResource;

enum ExerciseType: string
{
    case WEIGHT = 'weight';
    case CARDIO = 'cardio';
    case OTHER = 'other';
}
