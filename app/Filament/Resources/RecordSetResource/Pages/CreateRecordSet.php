<?php

namespace App\Filament\Resources\RecordSetResource\Pages;

use App\Filament\Resources\RecordSetResource;
use Filament\Resources\Pages\CreateRecord;

class CreateRecordSet extends CreateRecord
{
    protected static string $resource = RecordSetResource::class;

    protected function getHeaderActions(): array
    {
        return [

        ];
    }
}
