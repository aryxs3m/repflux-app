<?php

namespace App\Filament\Resources\MeasurementTypeResource\Pages;

use App\Filament\Abstract\Page\AbstractCreateRecord;
use App\Filament\Resources\MeasurementTypeResource;
use Illuminate\Contracts\Support\Htmlable;

class CreateMeasurementType extends AbstractCreateRecord
{
    protected static string $resource = MeasurementTypeResource::class;

    public function getTitle(): string|Htmlable
    {
        return __('pages.measurement_types.create_title');
    }

    protected function getHeaderActions(): array
    {
        return [

        ];
    }
}
