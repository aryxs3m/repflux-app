<?php

namespace App\Filament\Resources\RecordSetResource\Pages;

use App\Filament\Resources\RecordSetResource;
use App\Filament\Resources\RecordSetResource\Widgets\RecordSetChart;
use App\Filament\Resources\RecordTypeResource\Pages\ViewRecordType;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ViewRecordSet extends ViewRecordType
{
    protected static string $resource = RecordSetResource::class;

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
            Section::make('Set Type')->schema([
                TextEntry::make('recordType.name'),
                TextEntry::make('recordType.recordCategory.name'),
            ])->columns(2),
            Section::make('User')->schema([
                TextEntry::make('set_done_at')
                    ->date(),
                TextEntry::make('user.name'),
            ])->columns(2),
        ]);
    }
}
