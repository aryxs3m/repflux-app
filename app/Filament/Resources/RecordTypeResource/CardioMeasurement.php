<?php

namespace App\Filament\Resources\RecordTypeResource;

use Filament\Support\Contracts\HasLabel;

enum CardioMeasurement: string implements HasLabel
{
    case CALORIES = 'calories';
    case TIME = 'time';
    case DISTANCE = 'distance';
    case SPEED_DISTANCE = 'speed_distance';
    case SPEED_ROTATION = 'speed_rotation';
    case CLIMBED = 'climbed';
    case HEART_RATE = 'heart_rate';
    case STEPS = 'steps';

    public function getLabel(): string
    {
        return __(sprintf('measurement.%s', $this->value));
    }

    public function getMeasurementUnit(): string
    {
        return match ($this) {
            self::CALORIES => 'kcal',
            self::TIME, self::CLIMBED, self::DISTANCE => 'm',
            self::SPEED_DISTANCE => 'km/h',
            self::SPEED_ROTATION => 'rpm',
            self::HEART_RATE => 'bpm',
            default => '',
        };
    }

    public function getMeasurementType(): CardioMeasurementType
    {
        return match ($this) {
            self::SPEED_DISTANCE => CardioMeasurementType::FLOAT,
            default => CardioMeasurementType::INTEGER,
        };
    }

    public function getFieldName(): string
    {
        return 'cardio_measurement_'.$this->value;
    }
}
