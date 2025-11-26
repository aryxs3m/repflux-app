<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MeasurementTypeResource\Pages;
use App\Filament\Resources\MeasurementTypeResource\Schemas\MeasurementTypeForm;
use App\Filament\Resources\MeasurementTypeResource\Schemas\MeasurementTypeTable;
use App\Models\MeasurementType;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class MeasurementTypeResource extends Resource
{
    protected static ?string $model = MeasurementType::class;

    protected static ?string $slug = 'measurement-types';

    public static function getNavigationGroup(): string|UnitEnum|null
    {
        return __('navbar.settings');
    }

    public static function getNavigationLabel(): string
    {
        return __('navbar.measurement_types');
    }

    public static function getBreadcrumb(): string
    {
        return __('navbar.measurement_types');
    }

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return MeasurementTypeForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return MeasurementTypeTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMeasurementTypes::route('/'),
            'create' => Pages\CreateMeasurementType::route('/create'),
            'edit' => Pages\EditMeasurementType::route('/{record}/edit'),
        ];
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['name'];
    }
}
