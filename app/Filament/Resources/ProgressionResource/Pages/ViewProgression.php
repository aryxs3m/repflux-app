<?php

namespace App\Filament\Resources\ProgressionResource\Pages;

use App\Filament\Resources\ProgressionResource;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Contracts\Support\Htmlable;

class ViewProgression extends ViewRecord
{
    protected static string $resource = ProgressionResource::class;

    public function getTitle(): string|Htmlable
    {
        return $this->record->name;
    }

    protected function getHeaderWidgets(): array
    {
        return [
            ProgressionResource\Widgets\RecordTypeProgressionChart::class,
        ];
    }
}
