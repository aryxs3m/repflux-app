<?php

namespace App\Filament\Resources\MeasurementTypeResource;

use Filament\Support\Contracts\HasLabel;

enum BodyMeasurementType: string implements HasLabel
{
    case BICEPS_LEFT = 'biceps_left';
    case BICEPS_RIGHT = 'biceps_right';
    case CHEST = 'chest';
    case HIPS = 'hips';
    case WAIST = 'waist';
    case THIGHS_LEFT = 'thighs_left';
    case THIGHS_RIGHT = 'thighs_right';
    case NECK = 'neck';

    public function getLabel(): string
    {
        return __(sprintf('body_measurement.%s', $this->value));
    }
}
