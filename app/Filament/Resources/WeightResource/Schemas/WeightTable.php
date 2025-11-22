<?php

namespace App\Filament\Resources\WeightResource\Schemas;

use App\Filament\Abstract\Schema\AbstractTableSchema;
use App\Filament\Columns\ShortDateColumn;
use App\Filament\Filters\TenantUserFilter;
use App\Services\Settings\Tenant;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class WeightTable extends AbstractTableSchema
{
    public static function configure(Table $table): Table
    {
        return $table
            ->emptyStateDescription(__('pages.weight.empty_state'))
            ->emptyStateActions([
                CreateAction::make()
                    ->label(__('pages.weight.add_weight'))
                    ->icon(Heroicon::Plus),
            ])
            ->columns([
                TextColumn::make('user.name')
                    ->label(__('columns.name'))
                    ->visibleFrom('md'),
                ShortDateColumn::make('measured_at')
                    ->label(__('columns.measured_at')),
                TextColumn::make('weight')
                    ->label(__('columns.weight'))
                    ->suffix(' '.Tenant::getWeightUnitLabel()),
            ])
            ->defaultSort('measured_at', 'desc')
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
