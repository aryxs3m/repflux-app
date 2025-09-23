<?php

namespace App\Filament\Resources\RecordTypeResource;

use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Model;

abstract class CardioMeasurementTransformer
{
    public static function getInput(CardioMeasurement $measurement): TextInput
    {
        return TextInput::make('cardio_measurement_'.$measurement->value)
            ->nullable()
            ->minValue(0)
            ->suffix($measurement->getMeasurementUnit());
    }

    public static function get(Model $model, CardioMeasurement $measurement): ?string
    {
        $raw = $model->getAttribute('cardio_measurement_'.$measurement->value);

        return $raw.' '.$measurement->getMeasurementUnit();
    }
}
