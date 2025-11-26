<?php

namespace App\Filament\Exports;

use App\Models\RecordSet;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;
use Illuminate\Support\Number;

class RecordSetExporter extends Exporter
{
    protected static ?string $model = RecordSet::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id')
                ->label('ID'),
            ExportColumn::make('recordType.name'),
            ExportColumn::make('user.name'),
            ExportColumn::make('set_done_at'),
            ExportColumn::make('created_at'),
            ExportColumn::make('updated_at'),
            ExportColumn::make('tenant.name'),
            ExportColumn::make('workout.id'),
            ExportColumn::make('cardio_measurement_calories'),
            ExportColumn::make('cardio_measurement_time'),
            ExportColumn::make('cardio_measurement_distance'),
            ExportColumn::make('cardio_measurement_speed_distance'),
            ExportColumn::make('cardio_measurement_speed_rotation'),
            ExportColumn::make('cardio_measurement_climbed'),
            ExportColumn::make('cardio_measurement_heart_rate'),
            ExportColumn::make('cardio_measurement_steps'),
            ExportColumn::make('cardio_measurement_average_steps'),
            ExportColumn::make('time'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your record set export has completed and '.Number::format($export->successful_rows).' '.str('row')->plural($export->successful_rows).' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' '.Number::format($failedRowsCount).' '.str('row')->plural($failedRowsCount).' failed to export.';
        }

        return $body;
    }
}
