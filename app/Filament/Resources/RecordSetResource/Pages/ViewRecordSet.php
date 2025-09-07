<?php

namespace App\Filament\Resources\RecordSetResource\Pages;

use App\Filament\Resources\RecordSetResource;
use App\Filament\Resources\RecordSetResource\Widgets\RecordSetChart;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Pages\ViewRecord;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Contracts\Support\Htmlable;

class ViewRecordSet extends ViewRecord
{
    protected static string $resource = RecordSetResource::class;

    public function getTitle(): string|Htmlable
    {
        return __('pages.record_sets.view_title');
    }

    protected function getHeaderWidgets(): array
    {
        return [
            RecordSetResource\Widgets\RecordSetStats::class,
            RecordSetChart::class,
        ];
    }

    public function infolist(Schema $schema): Schema
    {
        return $schema->schema([
            Section::make('Exercise')->schema([
                TextEntry::make('recordType.name'),
                TextEntry::make('recordType.recordCategory.name')
                    ->label('Category'),
            ])->columns(2),
            Section::make('Record')->schema([
                TextEntry::make('set_done_at')
                    ->date(),
                TextEntry::make('user.name'),
            ])->columns(2),
        ]);
    }
}
