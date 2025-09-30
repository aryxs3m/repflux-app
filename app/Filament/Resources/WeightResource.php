<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WeightResource\Pages;
use App\Filament\Resources\WeightResource\Schemas\WeightForm;
use App\Filament\Resources\WeightResource\Schemas\WeightTable;
use App\Models\Weight;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use UnitEnum;

class WeightResource extends Resource
{
    protected static ?string $model = Weight::class;

    protected static ?string $slug = 'weights';

    public static function getBreadcrumb(): string
    {
        return __('navbar.weights');
    }

    public static function getNavigationGroup(): string|UnitEnum|null
    {
        return __('navbar.records');
    }

    public static function getNavigationLabel(): string
    {
        return __('navbar.weights');
    }

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-scale';

    public static function form(Schema $schema): Schema
    {
        return WeightForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return WeightTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListWeights::route('/'),
            'create' => Pages\CreateWeight::route('/create'),
            'edit' => Pages\EditWeight::route('/{record}/edit'),
        ];
    }

    public static function getGloballySearchableAttributes(): array
    {
        return [];
    }
}
