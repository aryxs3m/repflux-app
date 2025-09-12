<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RecordSetResource\Pages;
use App\Models\RecordCategory;
use App\Models\RecordSet;
use App\Models\RecordType;
use App\Services\RecordSetSessionService;
use App\Services\Settings\TenantSettings;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Field;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Components\Wizard;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Grouping\Group;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use UnitEnum;

class RecordSetResource extends Resource
{
    protected static ?string $model = RecordSet::class;

    protected static ?string $slug = 'record-sets';

    public static function getBreadcrumb(): string
    {
        return __('navbar.sets');
    }

    public static function getNavigationGroup(): string|UnitEnum|null
    {
        return __('navbar.records');
    }

    public static function getNavigationLabel(): string
    {
        return __('navbar.sets');
    }

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleGroup;

    public static function form(Schema $schema): Schema
    {
        $recordSetSession = app(RecordSetSessionService::class);

        return $schema
            ->components([
                Wizard::make([
                    Wizard\Step::make('Set')
                        ->schema([
                            Select::make('user_id')
                                ->options(TenantSettings::getTenant()->users->pluck('name', 'id'))
                                ->searchable()
                                ->default(auth()->id())
                                ->preload()
                                ->required(),
                            DatePicker::make('set_done_at')
                                ->label('Set Done Date')
                                ->default($recordSetSession->getLastSetDone() ?? now())
                                ->required(),
                            ToggleButtons::make('record_category_id')
                                ->live()
                                ->dehydrated(false)
                                ->options(RecordCategory::query()->get()->pluck('name', 'id'))
                                ->inline()
                                ->afterStateUpdated(function (Set $set) {
                                    $set('record_type_id', null);
                                }),
                            Select::make('record_type_id')
                                ->live()
                                ->placeholder(fn (Get $get): string => empty($get('record_category_id')) ? 'First select category' : 'Select an option')
                                ->options(function (?RecordSet $record, Get $get, Set $set, Field $component) use ($recordSetSession) {
                                    if (! empty($record) && empty($get('record_category_id'))) {
                                        $set('record_category_id', $record->recordType->recordCategory->id);
                                        $set('record_type_id', $record->recordType->id);
                                        $component->callAfterStateUpdated();
                                    }

                                    if (empty($record) && empty($get('record_category_id')) && $recordSetSession->hasLastRecord()) {
                                        $set('record_category_id', $recordSetSession->getLastRecordCategoryId());
                                        $set('record_type_id', $recordSetSession->getLastRecordTypeId());
                                        $component->callAfterStateUpdated();
                                    }

                                    return RecordType::query()
                                        ->where('record_category_id', $get('record_category_id'))
                                        ->orderBy('name')
                                        ->get()
                                        ->pluck('name', 'id');
                                })
                                ->afterStateHydrated(function ($state, Field $component) {
                                    $component->callAfterStateUpdated();
                                })
                                ->afterStateUpdated(function ($state, Field $component) {
                                    if (! empty($state) && $recordType = RecordType::query()->find($state)) {
                                        $component->hint($recordType->notes);
                                        if (! empty($recordType->notes)) {
                                            $component->hintIcon(Heroicon::InformationCircle);
                                        }
                                    } else {
                                        $component->hintIcon(null);
                                    }
                                })
                                ->required(),
                        ]),
                    Wizard\Step::make('Repetitions')
                        ->schema([
                            Repeater::make('records')
                                ->relationship('records')
                                ->hiddenLabel()
                                ->cloneable()
                                ->orderColumn('repeat_index')
                                ->reorderableWithButtons()
                                ->reorderableWithDragAndDrop(false)
                                ->minItems(1)
                                ->addActionLabel('Add repetition')
                                ->schema([
                                    TextInput::make('repeat_count')
                                        ->suffix('reps')
                                        ->numeric()
                                        ->minValue(0)
                                        ->columnSpan(1),
                                    TextInput::make('weight')
                                        ->suffix(TenantSettings::getWeightUnitLabel())
                                        ->numeric()
                                        ->minValue(0)
                                        ->columnSpan(1),
                                ])
                                ->columns([
                                    'default' => 2,
                                ]),
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
                    ->sortable()
                    ->date(),

                TextColumn::make('user.name')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('recordType.name')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('records.weight_with_base')
                    ->label('Rep weights')
                    ->badge(),

                TextColumn::make('total_weight')
                    ->label('Total weight')
                    ->state(function (RecordSet $recordSet): string {
                        return $recordSet->records->sum(fn ($record) => $record->weight_with_base * $record->repeat_count);
                    })
                    ->suffix(' '.TenantSettings::getWeightUnitLabel()),
            ])
            ->filters([
                SelectFilter::make('user')
                    ->relationship('user', 'name', fn (Builder $query) => $query->whereAttachedTo(TenantSettings::getTenant(), 'tenants')),
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
            ])
            ->groups([
                Group::make('user.name')
                    ->collapsible(),
            ])
            ->defaultSort('set_done_at', 'desc');
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
