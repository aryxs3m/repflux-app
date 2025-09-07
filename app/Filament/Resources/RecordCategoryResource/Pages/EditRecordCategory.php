<?php

namespace App\Filament\Resources\RecordCategoryResource\Pages;

use App\Filament\Resources\RecordCategoryResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Contracts\Support\Htmlable;

class EditRecordCategory extends EditRecord
{
    protected static string $resource = RecordCategoryResource::class;

    public function getTitle(): string|Htmlable
    {
        return __('pages.record_categories.edit_title');
    }

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
