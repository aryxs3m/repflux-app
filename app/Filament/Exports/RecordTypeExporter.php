<?php

namespace App\Filament\Exports;

use App\Models\RecordType;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;
use Illuminate\Support\Number;

class RecordTypeExporter extends Exporter
{
    protected static ?string $model = RecordType::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id')
                ->label('ID'),
            ExportColumn::make('name'),
            ExportColumn::make('recordCategory.name'),
            ExportColumn::make('created_at'),
            ExportColumn::make('updated_at'),
            ExportColumn::make('base_weight'),
            ExportColumn::make('tenant.name'),
            ExportColumn::make('notes'),
            ExportColumn::make('exercise_type'),
            ExportColumn::make('cardio_measurements'),
            ExportColumn::make('time_progression_type'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your record type export has completed and '.Number::format($export->successful_rows).' '.str('row')->plural($export->successful_rows).' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' '.Number::format($failedRowsCount).' '.str('row')->plural($failedRowsCount).' failed to export.';
        }

        return $body;
    }
}
