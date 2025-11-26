<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MeasurementResource\Pages;
use App\Filament\Resources\MeasurementResource\Schemas\MeasurementForm;
use App\Filament\Resources\MeasurementResource\Schemas\MeasurementTable;
use App\Models\Measurement;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use UnitEnum;

class MeasurementResource extends Resource
{
    protected static ?string $model = Measurement::class;

    protected static ?string $slug = 'measurements';

    public static function getNavigationGroup(): string|UnitEnum|null
    {
        return __('navbar.records');
    }

    public static function getNavigationLabel(): string
    {
        return __('navbar.measurements');
    }

    public static function getBreadcrumb(): string
    {
        return __('navbar.measurements');
    }

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedClipboardDocumentList;

    public static function form(Schema $schema): Schema
    {
        return MeasurementForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return MeasurementTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMeasurements::route('/'),
            'bulk' => Pages\AddBulkMeasurement::route('/bulk-create'),
            'create' => Pages\CreateMeasurement::route('/create'),
            'edit' => Pages\EditMeasurement::route('/{record}/edit'),
        ];
    }

    public static function getGlobalSearchEloquentQuery(): Builder
    {
        return parent::getGlobalSearchEloquentQuery()->with(['measurementType']);
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['measurementType.name'];
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        $details = [];

        if ($record->measurementType) {
            $details['MeasurementType'] = $record->measurementType->name;
        }

        return $details;
    }
}
