<?php

namespace App\Filament\Resources\RecordTypeResource\Pages;

use App\Filament\Exports\RecordTypeExporter;
use App\Filament\Resources\RecordTypeResource;
use Filament\Actions\ActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\ExportAction;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Contracts\Support\Htmlable;

class ListRecordTypes extends ListRecords
{
    protected static string $resource = RecordTypeResource::class;

    public function getTitle(): string|Htmlable
    {
        return __('pages.record_types.list_title');
    }

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label(__('pages.record_types.add_type')),
            ActionGroup::make([
                ExportAction::make()
                    ->label(__('common.export'))
                    ->exporter(RecordTypeExporter::class),
            ]),
        ];
    }
}
