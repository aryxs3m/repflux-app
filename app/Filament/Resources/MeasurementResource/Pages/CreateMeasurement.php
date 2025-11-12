<?php

namespace App\Filament\Resources\MeasurementResource\Pages;

use App\Filament\AbstractCreateRecord;
use App\Filament\Resources\MeasurementResource;
use Illuminate\Contracts\Support\Htmlable;

class CreateMeasurement extends AbstractCreateRecord
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
