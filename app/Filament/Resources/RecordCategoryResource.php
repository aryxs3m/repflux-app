<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RecordCategoryResource\Pages;
use App\Filament\Resources\RecordCategoryResource\Schemas\RecordCategoryForm;
use App\Filament\Resources\RecordCategoryResource\Schemas\RecordCategoryTable;
use App\Models\RecordCategory;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class RecordCategoryResource extends Resource
{
    protected static ?string $model = RecordCategory::class;

    protected static ?string $slug = 'record-categories';

    public static function getBreadcrumb(): string
    {
        return __('navbar.record_categories');
    }

    public static function getNavigationGroup(): string|UnitEnum|null
    {
        return __('navbar.settings');
    }

    public static function getNavigationLabel(): string
    {
        return __('navbar.record_categories');
    }

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return RecordCategoryForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return RecordCategoryTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRecordCategories::route('/'),
            'create' => Pages\CreateRecordCategory::route('/create'),
            'edit' => Pages\EditRecordCategory::route('/{record}/edit'),
        ];
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['name'];
    }
}
