<?php

namespace App\Filament\Resources\RecordCategoryResource\Pages;

use App\Filament\Resources\RecordCategoryResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListRecordCategories extends ListRecords
{
    protected static string $resource = RecordCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
