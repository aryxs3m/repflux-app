<?php

namespace App\Filament\Resources\RecordSetResource\Widgets;

use App\Models\RecordSet;
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
        $weightSum = $recordSet->records->sum(function ($record) {
            return $record->weight * $record->repeat_count;
        });

        return Stat::make('Moved Weight', $weightSum . ' kg')
            ->description('Total weight moved in this set')
            ->icon('heroicon-s-scale');
    }

    protected function totalReps(RecordSet $recordSet)
    {
        $repSum = $recordSet->records->sum(function ($record) {
            return $record->repeat_count;
        });

        return Stat::make('Repetitions', $repSum)
            ->description('Total repetitions in this set')
            ->icon('heroicon-s-arrow-path');
    }
}
