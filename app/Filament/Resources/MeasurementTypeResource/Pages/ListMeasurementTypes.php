<?php

namespace App\Filament\Resources\MeasurementTypeResource\Pages;

use App\Filament\Resources\MeasurementTypeResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Contracts\Support\Htmlable;

class ListMeasurementTypes extends ListRecords
{
    protected static string $resource = MeasurementTypeResource::class;

    public function getTitle(): string|Htmlable
    {
        return __('pages.measurement_types.list_title');
    }

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label(__('pages.measurement_types.add_type')),
        ];
    }
}
