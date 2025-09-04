<?php

namespace App\Filament\Resources\RecordSetResource\Pages;

use App\Filament\Resources\RecordSetResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditRecordSet extends EditRecord
{
    protected static string $resource = RecordSetResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
