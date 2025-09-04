<?php

namespace App\Filament\Resources\MeasurementTypeResource\Pages;

use App\Filament\Resources\MeasurementTypeResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListMeasurementTypes extends ListRecords
{
    protected static string $resource = MeasurementTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
