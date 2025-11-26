<?php

namespace App\Filament\Resources\ProgressionResource\Widgets;

use App\Models\Record;
use App\Models\RecordType;
use App\Services\OneRepMaxCalculator;
use App\Services\PersonalRecordsService;
use App\Services\Settings\Tenant;
use Filament\Support\Icons\Heroicon;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ProgressionStatWidgets extends StatsOverviewWidget
{
    protected ?string $pollingInterval = null;

    public ?RecordType $record = null;

    protected function getStats(): array
    {
        return array_merge([
            $this->prStat($this->record),
        ], $this->oneRepMaxes($this->record));
    }

    protected function prStat(RecordType $record)
    {
        $records = app(PersonalRecordsService::class)->getRecords();

        return Stat::make(
            __('pages.record_sets.widget.pr.title'),
            Tenant::numberFormat($records[$record->id] ?? null, Tenant::getWeightUnitLabel())
        )
            ->icon(Heroicon::OutlinedTrophy)
            ->description(__('pages.record_sets.widget.pr.description'));
    }

    protected function oneRepMaxes(RecordType $record)
    {
        $records = app(PersonalRecordsService::class)->getRecords();
        $maxWeight = $records[$record->id] ?? null;
        $brzyczkiWeight = null;
        $epleyWeight = null;

        if ($maxWeight) {
            $prRecord = Record::query()
                ->with('recordSet')
                ->whereRelation('recordSet', 'record_type_id', $record->id)
                ->where('weight', '=', $maxWeight - $record->base_weight)
                ->orderBy('weight', 'desc')
                ->first();

            $brzyczkiWeight = app(OneRepMaxCalculator::class)->getBrzyckiOneRepMax(
                $prRecord->weight_with_base,
                $prRecord->repeat_count
            );

            $epleyWeight = app(OneRepMaxCalculator::class)->getEpleyOneRepMax(
                $prRecord->weight_with_base,
                $prRecord->repeat_count
            );
        }

        return [
            Stat::make(
                __('pages.progression.widgets.brzycki.title'),
                Tenant::numberFormat($brzyczkiWeight, Tenant::getWeightUnitLabel())
            )
                ->icon(Heroicon::Fire)
                ->description(__('pages.progression.widgets.brzycki.description')),
            Stat::make(
                __('pages.progression.widgets.epley.title'),
                Tenant::numberFormat($epleyWeight, Tenant::getWeightUnitLabel())
            )
                ->icon(Heroicon::Fire)
                ->description(__('pages.progression.widgets.epley.description')),
        ];
    }
}
