<?php

namespace App\Filament\Resources\WorkoutResource\Schemas;

use App\Filament\Abstract\Schema\AbstractTableSchema;
use App\Filament\Columns\ShortDateColumn;
use App\Filament\Resources\RecordSetResource\Actions\CreateRecordSetAction;
use App\Services\Settings\Tenant;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class WorkoutTable extends AbstractTableSchema
{
    public static function configure(Table $table): Table
    {
        return $table
            ->emptyStateDescription(__('pages.workouts.empty_state'))
            ->emptyStateActions([
                CreateRecordSetAction::make()
                    ->icon(Heroicon::Plus),
            ])
            ->defaultSort('workout_at', 'desc')
            ->columns([
                ShortDateColumn::make('workout_at')
                    ->label('Workout Date'),

                TextColumn::make('dominantCategory.name'),
                TextColumn::make('calc_total_weight')
                    ->suffix(' '.Tenant::getWeightUnitLabel()),
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
}
