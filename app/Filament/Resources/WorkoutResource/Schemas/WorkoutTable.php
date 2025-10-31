<?php

namespace App\Filament\Resources\WorkoutResource\Schemas;

use App\Filament\AbstractTableSchema;
use App\Filament\Columns\ShortDateColumn;
use App\Services\Settings\Tenant;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class WorkoutTable extends AbstractTableSchema
{
    public static function configure(Table $table): Table
    {
        return $table
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
