<?php

namespace App\Filament\Resources\RecordSetResource\Schemas;

use App\Filament\Abstract\Schema\AbstractTableSchema;
use App\Filament\Columns\ShortDateColumn;
use App\Filament\Columns\UserBadgeColumn;
use App\Filament\Filters\TenantUserFilter;
use App\Filament\Resources\RecordSetResource\Actions\CreateRecordSetAction;
use App\Filament\Resources\RecordTypeResource\ExerciseType;
use App\Models\RecordSet;
use App\Services\Settings\Tenant;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Grouping\Group;
use Filament\Tables\Table;

class RecordSetTable extends AbstractTableSchema
{
    public static function configure(Table $table): Table
    {
        return $table
            ->emptyStateDescription(__('pages.record_sets.empty_state'))
            ->emptyStateActions([
                CreateRecordSetAction::make()
                    ->icon(Heroicon::Plus),
            ])
            ->columns([
                Stack::make([
                    TextColumn::make('recordType.name')
                        ->searchable()
                        ->sortable(),

                    Split::make([
                        UserBadgeColumn::make('user')
                            ->sortable(),
                        ShortDateColumn::make('set_done_at')
                            ->alignEnd()
                            ->label('Set Done Date')
                            ->sortable(),
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
                TenantUserFilter::make(),
            ])
            ->recordActions([
                ViewAction::make()
                    ->hiddenLabel()
                    ->size('6xl'),
                EditAction::make()
                    ->hiddenLabel()
                    ->size('6xl'),
                DeleteAction::make()
                    ->hiddenLabel()
                    ->size('6xl'),
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
            ->paginationPageOptions([12, 24, 36, 48, 60])
            ->defaultPaginationPageOption(24)
            ->defaultSort('id', 'desc');
    }
}
