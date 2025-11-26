<?php

namespace App\Filament\Resources\RecordCategoryResource\Schemas;

use App\Filament\Abstract\Schema\AbstractTableSchema;
use App\Filament\Actions\StarterDataAction;
use App\Services\StarterData\Data\RecordCategoryTenantSeeder;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class RecordCategoryTable extends AbstractTableSchema
{
    public static function configure(Table $table): Table
    {
        return $table
            ->emptyStateDescription(__('pages.record_categories.empty_state'))
            ->emptyStateActions([
                StarterDataAction::make()
                    ->setSeeder(RecordCategoryTenantSeeder::class),
                CreateAction::make()
                    ->label(__('pages.record_categories.add_category'))
                    ->icon(Heroicon::Plus),
            ])
            ->columns([
                TextColumn::make('name')
                    ->label(__('columns.name'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label(__('columns.created_at'))
                    ->date()
                    ->sortable(),
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
