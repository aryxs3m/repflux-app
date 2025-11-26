<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RecordSetResource\Pages;
use App\Filament\Resources\RecordSetResource\Schemas\RecordSetForm;
use App\Filament\Resources\RecordSetResource\Schemas\RecordSetTable;
use App\Models\RecordSet;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use UnitEnum;

class RecordSetResource extends Resource
{
    protected static ?string $model = RecordSet::class;

    protected static ?string $slug = 'record-sets';

    public static function getBreadcrumb(): string
    {
        return __('navbar.sets');
    }

    public static function getNavigationGroup(): string|UnitEnum|null
    {
        return __('navbar.records');
    }

    public static function getNavigationLabel(): string
    {
        return __('navbar.sets');
    }

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleGroup;

    public static function form(Schema $schema): Schema
    {
        return RecordSetForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return RecordSetTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRecordSets::route('/'),
            'view' => Pages\ViewRecordSet::route('/view/{record}'),
            'create' => Pages\CreateRecordSet::route('/create'),
            'edit' => Pages\EditRecordSet::route('/{record}/edit'),
        ];
    }

    public static function getGlobalSearchEloquentQuery(): Builder
    {
        return parent::getGlobalSearchEloquentQuery()->with(['recordType', 'user']);
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['recordType.name', 'user.name'];
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        $details = [];

        if ($record->recordType) {
            $details['RecordType'] = $record->recordType->name;
        }

        if ($record->user) {
            $details['User'] = $record->user->name;
        }

        return $details;
    }
}
