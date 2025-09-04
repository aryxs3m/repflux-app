<?php

namespace App\Filament\Resources\MeasurementTypeResource\Pages;

use App\Filament\Resources\MeasurementTypeResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditMeasurementType extends EditRecord
{
    protected static string $resource = MeasurementTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
