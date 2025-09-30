<?php

namespace App\Filament\Resources\MeasurementResource\Schemas;

use App\Filament\AbstractTableSchema;
use App\Filament\Filters\TenantUserFilter;
use App\Services\Settings\Tenant;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class MeasurementTable extends AbstractTableSchema
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultPaginationPageOption(5)
            ->columns([
                TextColumn::make('user.name')
                    ->label(__('columns.name'))
                    ->visibleFrom('md')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('measurementType.name')
                    ->label(__('columns.type'))
                    ->searchable()
                    ->sortable(),

                TextColumn::make('measured_at')
                    ->label(__('columns.measured_at'))
                    ->date(),

                TextColumn::make('value')
                    ->label(__('columns.value'))
                    ->suffix(' '.Tenant::getLengthUnitLabel()),
            ])
            ->filters([
                TenantUserFilter::make()->defaultSelf(),
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
}
