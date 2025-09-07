<?php

namespace App\Filament\Resources\MeasurementResource\Pages;

use App\Filament\Resources\MeasurementResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Contracts\Support\Htmlable;

class CreateMeasurement extends CreateRecord
{
    protected static string $resource = MeasurementResource::class;

    public function getTitle(): string|Htmlable
    {
        return __('pages.measurements.create_title');
    }

    protected function getHeaderActions(): array
    {
        return [

        ];
    }
}
