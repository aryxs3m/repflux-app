<?php

namespace App\Filament\Resources\RecordSetResource\Widgets;

use App\Models\RecordSet;
use App\Services\Settings\TenantSettings;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class RecordSetStats extends StatsOverviewWidget
{
    public ?RecordSet $record = null;

    protected function getStats(): array
    {
        return [
            $this->totalMovedWeight($this->record),
            $this->totalReps($this->record),
        ];
    }

    protected function totalMovedWeight(RecordSet $recordSet)
    {
        $weightSum = $recordSet->records->sum(function ($record) use ($recordSet) {
            return $record->weight_with_base * $record->repeat_count;
        });

        return Stat::make(__('pages.record_sets.widget.moved_weight.title'), $weightSum . ' '. TenantSettings::getWeightUnitLabel())
            ->description(__('pages.record_sets.widget.moved_weight.description'))
            ->icon('heroicon-s-scale');
    }

    protected function totalReps(RecordSet $recordSet)
    {
        $repSum = $recordSet->records->sum(function ($record) {
            return $record->repeat_count;
        });

        return Stat::make(__('pages.record_sets.widget.repetitions.title'), $repSum)
            ->description(__('pages.record_sets.widget.repetitions.description'))
            ->icon('heroicon-s-arrow-path');
    }
}
