<?php

namespace App\Filament\Resources\RecordTypeResource\Pages;

use App\Filament\Resources\RecordTypeResource;
use Filament\Resources\Pages\CreateRecord;

class CreateRecordType extends CreateRecord
{
    protected static string $resource = RecordTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [

        ];
    }
}
