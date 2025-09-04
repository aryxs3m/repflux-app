<?php

namespace App\Filament\Resources\RecordTypeResource\Pages;

use App\Filament\Resources\RecordTypeResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListRecordTypes extends ListRecords
{
    protected static string $resource = RecordTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
