<?php

namespace App\Filament\Resources\ProgressionResource\Schemas;

use App\Filament\AbstractTableSchema;
use App\Models\RecordType;
use App\Services\PersonalRecordsService;
use App\Services\Settings\Tenant;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ProgressionTable extends AbstractTableSchema
{
    public static function configure(Table $table): Table
    {
        $records = app(PersonalRecordsService::class)->getRecords();

        return $table
            ->columns([
                TextColumn::make('recordCategory.name')
                    ->visibleFrom('md')
                    ->label(__('columns.category'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('name')
                    ->label(__('columns.exercise'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('pr')
                    ->state(function (RecordType $record) use ($records): ?string {
                        return Tenant::numberFormat($records[$record->id] ?? null, Tenant::getWeightUnitLabel());
                    }),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
            ])
            ->toolbarActions([]);
    }
}
