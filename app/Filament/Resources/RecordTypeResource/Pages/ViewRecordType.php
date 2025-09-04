<?php

namespace App\Filament\Resources\RecordTypeResource\Pages;

use App\Filament\Resources\RecordTypeResource;
use App\Filament\Resources\RecordTypeResource\Widgets\RecordTypeProgressionChart;
use Filament\Resources\Pages\ViewRecord;

class ViewRecordType extends ViewRecord
{
    protected static string $resource = RecordTypeResource::class;

    protected function getHeaderWidgets(): array
    {
        return [
            RecordTypeProgressionChart::class,
        ];
    }
}
