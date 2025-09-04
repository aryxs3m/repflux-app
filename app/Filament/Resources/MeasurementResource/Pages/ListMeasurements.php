<?php

namespace App\Filament\Resources\MeasurementResource\Pages;

use App\Filament\Resources\MeasurementResource;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListMeasurements extends ListRecords
{
    protected static string $resource = MeasurementResource::class;

    protected function getHeaderWidgets(): array
    {
        return [
            //MeasurementResource\Widgets\MeasurementWidget::class,
            MeasurementResource\Widgets\MeasurementStats::class,
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('Measure Now')
                ->color('success')
                ->icon('heroicon-o-plus-circle')
                ->url(route('filament.app.resources.measurements.bulk')),
            CreateAction::make()
                ->label('Add single measurement'),
        ];
    }
}
