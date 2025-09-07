<?php

namespace App\Filament\Resources\RecordSetResource\Pages;

use App\Filament\Resources\RecordSetResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Contracts\Support\Htmlable;

class CreateRecordSet extends CreateRecord
{
    protected static string $resource = RecordSetResource::class;

    public function getTitle(): string|Htmlable
    {
        return __('pages.record_sets.create_title');
    }

    protected function getHeaderActions(): array
    {
        return [

        ];
    }
}
