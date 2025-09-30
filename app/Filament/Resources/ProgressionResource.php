<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProgressionResource\Pages;
use App\Filament\Resources\ProgressionResource\Schemas\ProgressionTable;
use App\Models\RecordType;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class ProgressionResource extends Resource
{
    protected static ?string $model = RecordType::class;

    protected static ?string $slug = 'progression';

    public static function getBreadcrumb(): string
    {
        return __('navbar.progression');
    }

    public static function getNavigationGroup(): string|UnitEnum|null
    {
        return __('navbar.reports');
    }

    public static function getNavigationLabel(): string
    {
        return __('navbar.progression');
    }

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedDocumentChartBar;

    public static function table(Table $table): Table
    {
        return ProgressionTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProgression::route('/'),
            'view' => Pages\ViewProgression::route('/view/{record}'),
        ];
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['name'];
    }
}
