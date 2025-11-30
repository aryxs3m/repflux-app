<?php

namespace App\Filament\Resources\MeasurementResource\Pages;

use App\Filament\Exports\MeasurementExporter;
use App\Filament\Resources\MeasurementResource;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\ExportAction;
use Filament\Facades\Filament;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Contracts\Support\Htmlable;

class ListMeasurements extends ListRecords
{
    protected static string $resource = MeasurementResource::class;

    public function getTitle(): string|Htmlable
    {
        return __('pages.measurements.list_title');
    }

    protected function getHeaderWidgets(): array
    {
        return [
            //MeasurementResource\Widgets\MeasurementWidget::class,
            MeasurementResource\Widgets\BRIStat::class,
            MeasurementResource\Widgets\MeasurementStats::class,
            MeasurementResource\Widgets\MeasurementChart::class,
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('Measure Now')
                ->label(__('pages.measurements.measure_now'))
                ->color('success')
                ->icon('heroicon-o-plus-circle')
                ->url(route('filament.app.resources.measurements.bulk', ['tenant' => Filament::getTenant()])),
            CreateAction::make()
                ->label(__('pages.measurements.add_single')),
            ActionGroup::make([
                ExportAction::make()
                    ->label(__('common.export'))
                    ->exporter(MeasurementExporter::class),
            ]),
        ];
    }
}
