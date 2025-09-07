<?php

namespace App\Filament\Resources\RecordCategoryResource\Pages;

use App\Filament\Resources\RecordCategoryResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Contracts\Support\Htmlable;

class ListRecordCategories extends ListRecords
{
    protected static string $resource = RecordCategoryResource::class;

    public function getTitle(): string|Htmlable
    {
        return __('pages.record_categories.list_title');
    }

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label(__('pages.record_categories.add_category')),
        ];
    }
}
