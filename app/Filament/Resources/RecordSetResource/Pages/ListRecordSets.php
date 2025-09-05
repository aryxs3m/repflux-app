<?php

namespace App\Filament\Resources\RecordSetResource\Pages;

use App\Filament\Resources\RecordSetResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListRecordSets extends ListRecords
{
    protected static ?string $title = 'Sets';

    protected static string $resource = RecordSetResource::class;

    protected function getHeaderWidgets(): array
    {
        return [
            RecordSetResource\Widgets\LastRecordsWidget::class,
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
