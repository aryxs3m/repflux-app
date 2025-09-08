<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RecordTypeResource\Pages;
use App\Models\RecordType;
use App\Services\Settings\TenantSettings;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
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

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('record_category_id')
                    ->relationship('recordCategory', 'name')
                    ->required(),

                TextInput::make('name')
                    ->required(),

                TextInput::make('base_weight')
                    ->default(0)
                    ->suffix(TenantSettings::getWeightUnitLabel())
                    ->required(),

                TextEntry::make('created_at')
                    ->label('Created Date')
                    ->state(fn (?RecordType $record): string => $record?->created_at?->diffForHumans() ?? '-'),

                TextEntry::make('updated_at')
                    ->label('Last Modified Date')
                    ->state(fn (?RecordType $record): string => $record?->updated_at?->diffForHumans() ?? '-'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('recordCategory.name')
                    ->label(__('columns.category'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('name')
                    ->label(__('columns.exercise'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('base_weight')
                    ->label(__('columns.base_weight'))
                    ->suffix(' '.TenantSettings::getWeightUnitLabel()),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
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
