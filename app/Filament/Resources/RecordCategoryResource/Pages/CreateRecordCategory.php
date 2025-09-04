<?php

namespace App\Filament\Resources\RecordCategoryResource\Pages;

use App\Filament\Resources\RecordCategoryResource;
use Filament\Resources\Pages\CreateRecord;

class CreateRecordCategory extends CreateRecord
{
    protected static string $resource = RecordCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [

        ];
    }
}
