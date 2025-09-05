<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RecordSetResource\Pages;
use App\Models\RecordCategory;
use App\Models\RecordSet;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Wizard;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class RecordSetResource extends Resource
{
    protected static ?string $model = RecordSet::class;

    protected static ?string $breadcrumb = 'Sets';
    protected static ?string $navigationLabel = 'Sets';
    protected static ?string $slug = 'record-sets';

    protected static string|null|\UnitEnum $navigationGroup = 'Records';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleGroup;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Wizard::make([
                    Wizard\Step::make('Set')
                        ->schema([
                            Select::make('user_id')
                                ->relationship('user', 'name')
                                ->searchable()
                                ->default(auth()->id())
                                ->required(),
                            DatePicker::make('set_done_at')
                                ->label('Set Done Date')
                                ->default(now())
                                ->required(),
                            ToggleButtons::make('record_category_id')
                                ->options(RecordCategory::query()->get()->pluck('name', 'id'))
                                ->default(RecordCategory::query()->first()->id)
                                ->inline(),
                            // https://laraveldaily.com/post/filament-dependent-dropdowns-edit-form-set-select-values
                            Select::make('record_type_id')
                                ->relationship('recordType', 'name')
                                ->required(),
                        ]),
                    Wizard\Step::make('Repetitions')
                        ->schema([
                            Repeater::make('records')
                                ->relationship('records')
                                ->label('Repetitions')
                                ->orderColumn('repeat_index')
                                ->addActionLabel('Add repetition')
                                ->schema([
                                    TextInput::make('repeat_count')
                                        ->suffix('reps')
                                        ->numeric()
                                        ->minValue(0)
                                        ->columnSpan(1),
                                    TextInput::make('weight')
                                        ->suffix('kg')
                                        ->numeric()
                                        ->minValue(0)
                                        ->columnSpan(1),
                                ])
                                ->columns(2)
                        ]),
                ]),
            ])
            ->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('set_done_at')
                    ->label('Set Done Date')
                    ->date(),

                TextColumn::make('user.name')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('recordType.name')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('records.weight')
                    ->label('Rep weights')
                    ->badge(),

                TextColumn::make('total_weight')
                    ->label('Total weight')
                    ->state(function (RecordSet $recordSet): string {
                        return $recordSet->records->sum(fn ($record) => $record->weight * $record->repeat_count);
                    })
                    ->suffix(' kg'),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
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
