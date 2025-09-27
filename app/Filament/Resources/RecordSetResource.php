<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RecordSetResource\Pages;
use App\Filament\Resources\RecordSetResource\Schemas\RecordSetForm;
use App\Filament\Resources\RecordTypeResource\ExerciseType;
use App\Models\RecordSet;
use App\Services\Settings\Tenant;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\Layout\Stack;
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
        return RecordSetForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Stack::make([
                    TextColumn::make('set_done_at')
                        ->label('Set Done Date')
                        ->sortable()
                        ->date(),

                    Split::make([
                        TextColumn::make('user.name')
                            ->searchable()
                            ->sortable()
                            ->badge()
                            ->color('danger'),
                        TextColumn::make('recordType.name')
                            ->searchable()
                            ->sortable()
                            ->badge()
                            ->alignEnd()
                            ->color('blue'),
                    ]),

                    TextColumn::make('records.weight_with_base')
                        ->state(function (RecordSet $recordSet) {
                            if ($recordSet->recordType->exercise_type !== ExerciseType::WEIGHT) {
                                return null;
                            }

                            return $recordSet->records->pluck('weight_with_base');
                        })
                        ->label('Rep weights')
                        ->badge(),

                    TextColumn::make('total_weight')
                        ->label('Total weight')
                        ->state(function (RecordSet $recordSet): string {
                            return $recordSet->records->sum(fn ($record) => $record->weight_with_base * $record->repeat_count);
                        })
                        ->suffix(' '.Tenant::getWeightUnitLabel()),
                ]),
            ])
            ->contentGrid([
                'md' => 2,
                'xl' => 3,
            ])
            ->filters([
                SelectFilter::make('user')
                    ->relationship('user', 'name', fn (Builder $query) => $query->whereAttachedTo(Tenant::getTenant(), 'tenants')),
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
            ->defaultSort('id', 'desc');
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
