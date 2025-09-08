<?php

namespace App\Filament\Resources\RecordSetResource\Widgets;

use App\Filament\Resources\RecordSetResource;
use App\Models\RecordSet;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;

class LastRecordsWidget extends TableWidget
{
    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        $maxIds = \DB::select("
            SELECT rs.id
            FROM record_sets rs
            INNER JOIN
                (
                    SELECT record_type_id, MAX(set_done_at) as last_done_at
                    FROM record_sets rs2
                    WHERE rs2.user_id = ?
                    GROUP BY record_type_id) AS EachItem ON
                        EachItem.last_done_at = rs.set_done_at
                        AND EachItem.record_type_id = rs.record_type_id
            WHERE
                rs.user_id = ?
            ", [auth()->user()->id, auth()->user()->id]);

        return $table
            ->query(fn (): Builder =>
                RecordSet::query()
                    ->whereIn('id', array_column($maxIds, 'id'))
            )
            ->columns([
                TextColumn::make('set_done_at')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('recordType.name')
                    ->searchable(),
                TextColumn::make('records.weight_with_base')
                    ->label('Rep weights')
                    ->badge(),
            ])
            ->filters([
                //
            ])
            ->recordUrl(function ($record) {
                return RecordSetResource::getUrl('view', ['record' => $record->id]);
            });
    }
}
