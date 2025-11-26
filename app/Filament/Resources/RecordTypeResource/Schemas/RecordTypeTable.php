<?php

namespace App\Filament\Resources\RecordTypeResource\Schemas;

use App\Filament\Abstract\Schema\AbstractTableSchema;
use App\Filament\Actions\StarterDataAction;
use App\Services\Settings\Tenant;
use App\Services\StarterData\Data\RecordTypeTenantSeeder;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class RecordTypeTable extends AbstractTableSchema
{
    public static function configure(Table $table): Table
    {
        return $table
            ->emptyStateDescription(__('pages.record_types.empty_state'))
            ->emptyStateActions([
                StarterDataAction::make()
                    ->setSeeder(RecordTypeTenantSeeder::class),
                CreateAction::make()
                    ->label(__('pages.record_types.add_type'))
                    ->icon(Heroicon::Plus),
            ])
            ->columns([
                TextColumn::make('recordCategory.name')
                    ->label(__('columns.category'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('name')
                    ->label(__('columns.exercise'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('base_weight')
                    ->label(__('columns.base_weight'))
                    ->suffix(' '.Tenant::getWeightUnitLabel()),
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
}
