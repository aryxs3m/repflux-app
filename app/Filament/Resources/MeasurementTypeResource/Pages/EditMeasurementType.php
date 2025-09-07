<?php

namespace App\Filament\Resources\MeasurementTypeResource\Pages;

use App\Filament\Resources\MeasurementTypeResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Contracts\Support\Htmlable;

class EditMeasurementType extends EditRecord
{
    protected static string $resource = MeasurementTypeResource::class;

    public function getTitle(): string|Htmlable
    {
        return __('pages.measurement_types.edit_title');
    }

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
