<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RecordTypeResource\Pages;
use App\Filament\Resources\RecordTypeResource\Schemas\RecordTypeForm;
use App\Filament\Resources\RecordTypeResource\Schemas\RecordTypeTable;
use App\Models\RecordType;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class RecordTypeResource extends Resource
{
    protected static ?string $model = RecordType::class;

    protected static ?string $slug = 'record-types';

    public static function getBreadcrumb(): string
    {
        return __('navbar.record_types');
    }

    public static function getNavigationGroup(): string|UnitEnum|null
    {
        return __('navbar.settings');
    }

    public static function getNavigationLabel(): string
    {
        return __('navbar.record_types');
    }

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    /**
     * @throws \Exception
     */
    public static function form(Schema $schema): Schema
    {
        return RecordTypeForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return RecordTypeTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRecordTypes::route('/'),
            'create' => Pages\CreateRecordType::route('/create'),
            'edit' => Pages\EditRecordType::route('/{record}/edit'),
        ];
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['name'];
    }
}
