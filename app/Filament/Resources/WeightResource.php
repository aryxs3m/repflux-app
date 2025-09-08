<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WeightResource\Pages;
use App\Models\Weight;
use App\Services\Settings\TenantSettings;
use BackedEnum;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
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

    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-scale';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Select::make('user_id')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->default(auth()->id())
                    ->required(),

                TextInput::make('weight')
                    ->required()
                    ->suffix(TenantSettings::getWeightUnitLabel())
                    ->minValue(1)
                    ->integer(),

                DatePicker::make('measured_at')
                    ->label('Measured Date')
                    ->default(now())
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('measured_at')
                    ->label(__('columns.measured_at'))
                    ->date(),

                TextColumn::make('weight')
                    ->label(__('columns.weight'))
                    ->suffix(' '.TenantSettings::getWeightUnitLabel()),
            ])
            ->filters([
                //
            ])
            ->actions([
                \Filament\Actions\EditAction::make(),
                \Filament\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                \Filament\Actions\BulkActionGroup::make([
                    \Filament\Actions\DeleteBulkAction::make(),
                ]),
            ]);
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
