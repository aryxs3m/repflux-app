<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MeasurementResource\Pages;
use App\Models\Measurement;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use UnitEnum;

class MeasurementResource extends Resource
{
    protected static ?string $model = Measurement::class;

    protected static ?string $slug = 'measurements';
    protected static string | UnitEnum | null $navigationGroup = 'Records';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedClipboardDocumentList;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->default(auth()->id())
                    ->required(),

                Select::make('measurement_type_id')
                    ->relationship('measurementType', 'name')
                    ->required(),

                DatePicker::make('measured_at')
                    ->label('Measured Date')
                    ->default(now()),

                TextInput::make('value')
                    ->required()
                    ->integer(),

                TextEntry::make('created_at')
                    ->label('Created Date')
                    ->state(fn(?Measurement $record): string => $record?->created_at?->diffForHumans() ?? '-'),

                TextEntry::make('updated_at')
                    ->label('Last Modified Date')
                    ->state(fn(?Measurement $record): string => $record?->updated_at?->diffForHumans() ?? '-'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('measurementType.name')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('measured_at')
                    ->label('Measured Date')
                    ->date(),

                TextColumn::make('value'),
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
