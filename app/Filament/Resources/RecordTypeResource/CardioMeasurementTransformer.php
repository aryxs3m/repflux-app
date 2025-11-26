<?php

namespace App\Filament\Resources\RecordTypeResource;

use App\Models\RecordSet;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\TextEntry;
use Illuminate\Database\Eloquent\Model;

abstract class CardioMeasurementTransformer
{
    public static function getInput(CardioMeasurement $measurement): TextInput
    {
        return TextInput::make('cardio_measurement_'.$measurement->value)
            ->label($measurement->getLabel())
            ->numeric()
            ->nullable()
            ->minValue(0)
            ->suffix($measurement->getMeasurementUnit());
    }

    public static function getEntries(RecordSet $recordSet): array
    {
        $entries = [];

        foreach ($recordSet->recordType->cardio_measurements as $cardio_measurement) {
            $measurement = CardioMeasurement::from($cardio_measurement);

            $entries[] = TextEntry::make('cardio_measurement_'.$measurement->value)
                ->suffix(' '.$measurement->getMeasurementUnit())
                ->label($measurement->getLabel());
        }

        return $entries;
    }

    public static function get(Model $model, CardioMeasurement $measurement): ?string
    {
        $raw = $model->getAttribute('cardio_measurement_'.$measurement->value);

        return $raw.' '.$measurement->getMeasurementUnit();
    }
}
