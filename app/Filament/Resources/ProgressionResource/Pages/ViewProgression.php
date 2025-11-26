<?php

namespace App\Filament\Resources\ProgressionResource\Pages;

use App\Filament\Actions\NewRecordSetAction;
use App\Filament\Resources\ProgressionResource;
use App\Models\RecordType;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Contracts\Support\Htmlable;

/**
 * @property RecordType $record
 */
class ViewProgression extends ViewRecord
{
    protected static string $resource = ProgressionResource::class;

    public function getTitle(): string|Htmlable
    {
        return $this->record->name;
    }

    protected function getHeaderActions(): array
    {
        return [
            NewRecordSetAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            ProgressionResource\Widgets\ProgressionStatWidgets::class,
            ProgressionResource\Widgets\RecordTypeProgressionChart::class,
        ];
    }
}
