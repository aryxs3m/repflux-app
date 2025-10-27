<?php

namespace App\Filament\Resources\RecordSetResource\Schemas;

use App\Filament\AbstractTableSchema;
use App\Filament\Filters\TenantUserFilter;
use App\Filament\Resources\RecordTypeResource\ExerciseType;
use App\Models\RecordSet;
use App\Services\Settings\Tenant;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
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
            ->columns([
                Stack::make([
                    TextColumn::make('recordType.name')
                        ->searchable()
                        ->sortable()
                        ->badge()
                        ->color('blue'),

                    Split::make([
                        TextColumn::make('user.name')
                            ->searchable()
                            ->sortable()
                            ->badge()
                            ->color('danger'),
                        TextColumn::make('set_done_at')
                            ->alignEnd()
                            ->label('Set Done Date')
                            ->sortable()
                            ->date(),
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
}
