<?php

namespace App\Filament\Resources\RecordCategoryResource\Pages;

use App\Filament\AbstractCreateRecord;
use App\Filament\Resources\RecordCategoryResource;
use Illuminate\Contracts\Support\Htmlable;

class CreateRecordCategory extends AbstractCreateRecord
{
    protected static string $resource = RecordCategoryResource::class;

    public function getTitle(): string|Htmlable
    {
        return __('pages.record_categories.create_title');
    }

    protected function getHeaderActions(): array
    {
        return [

        ];
    }
}
