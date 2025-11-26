<?php

namespace App\Filament\Resources\MeasurementTypeResource\Schemas;

use App\Filament\Abstract\Schema\AbstractTableSchema;
use App\Services\Settings\Tenant;
use App\Services\StarterData\Data\MeasurementTypeTenantSeeder;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Notifications\Notification;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class MeasurementTypeTable extends AbstractTableSchema
{
    public static function configure(Table $table): Table
    {
        return $table
            ->emptyStateDescription(__('pages.measurement_types.empty_state'))
            ->emptyStateActions([
                Action::make('load_default')
                    ->defaultColor('gray')
                    ->label(__('common.load_default'))
                    ->action(function () {
                        MeasurementTypeTenantSeeder::seed(Tenant::getTenant());
                        Notification::make()
                            ->success()
                            ->title(__('notifications.success'))
                            ->body(__('notifications.starter_data_loaded'))
                            ->send();
                    })
                    ->icon(Heroicon::FolderPlus),
                CreateAction::make()
                    ->label(__('pages.measurement_types.add_type'))
                    ->icon(Heroicon::Plus),
            ])
            ->columns([
                TextColumn::make('name')
                    ->label(__('columns.name'))
                    ->searchable()
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
