<?php

namespace App\Filament\Resources\MeasurementTypeResource\Pages;

use App\Filament\Resources\MeasurementTypeResource;
use Filament\Resources\Pages\CreateRecord;

class CreateMeasurementType extends CreateRecord
{
    protected static string $resource = MeasurementTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [

        ];
    }
}
