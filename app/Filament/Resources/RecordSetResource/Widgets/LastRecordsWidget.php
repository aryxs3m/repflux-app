<?php

namespace App\Filament\Resources\RecordSetResource\Widgets;

use App\Models\RecordSet;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;

class LastRecordsWidget extends TableWidget
{
    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(fn (): Builder =>
                RecordSet::query()
                    ->selectRaw('*, MAX(set_done_at) as set_done_at_max')
                    ->where('user_id', auth()->id())
                    ->groupBy('record_type_id')
            )
            ->columns([
                TextColumn::make('set_done_at')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('recordType.name')
                    ->searchable(),
                TextColumn::make('records.weight')
                    ->label('Rep weights')
                    ->badge(),
            ])
            ->filters([
                //
            ])
            ->recordUrl(function ($record) {
                return route('filament.app.resources.record-sets.view', ['record' => $record->id]);
            });
    }
}
