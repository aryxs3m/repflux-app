<?php

namespace App\Filament\Resources\RecordCategoryResource\Pages;

use App\Filament\Resources\RecordCategoryResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditRecordCategory extends EditRecord
{
    protected static string $resource = RecordCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
