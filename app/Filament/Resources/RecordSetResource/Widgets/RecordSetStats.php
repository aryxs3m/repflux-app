<?php

namespace App\Filament\Resources\RecordSetResource\Widgets;

use App\Filament\Fields\StopwatchCast;
use App\Filament\Resources\ProgressionResource\Pages\ViewProgression;
use App\Filament\Resources\RecordTypeResource\CardioMeasurement;
use App\Filament\Resources\RecordTypeResource\CardioMeasurementTransformer;
use App\Filament\Resources\RecordTypeResource\ExerciseType;
use App\Models\RecordSet;
use App\Services\PersonalRecordsService;
use App\Services\Settings\Tenant;
use Filament\Support\Icons\Heroicon;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class RecordSetStats extends StatsOverviewWidget
{
    protected ?string $pollingInterval = null;

    public ?RecordSet $record = null;

    protected function getStats(): array
    {
        if ($this->record->recordType->exercise_type == ExerciseType::CARDIO) {
            return $this->cardioStats($this->record);
        }

        if ($this->record->recordType->exercise_type == ExerciseType::WEIGHT) {
            return [
                $this->totalMovedWeight($this->record),
                $this->totalReps($this->record),
                $this->prStat($this->record),
            ];
        }

        if ($this->record->recordType->exercise_type == ExerciseType::OTHER) {
            return [
                $this->totalReps($this->record),
            ];
        }

        if ($this->record->recordType->exercise_type == ExerciseType::TIME) {
            return [
                $this->timeStat($this->record),
            ];
        }

        return [];
    }

    protected function cardioStats(RecordSet $recordSet): array
    {
        $stats = [];

        foreach ($recordSet->recordType->cardio_measurements as $measurement) {
            $cardioMeasurement = CardioMeasurement::from($measurement);
            $stats[] = Stat::make(
                $cardioMeasurement->getLabel(),
                CardioMeasurementTransformer::get($recordSet, $cardioMeasurement)
            );
        }

        return $stats;
    }

    protected function totalMovedWeight(RecordSet $recordSet)
    {
        $weightSum = $recordSet->records->sum(function ($record) {
            return $record->weight_with_base * $record->repeat_count;
        });

        return Stat::make(__('pages.record_sets.widget.moved_weight.title'), $weightSum.' '.Tenant::getWeightUnitLabel())
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

    protected function prStat(RecordSet $record)
    {
        $records = app(PersonalRecordsService::class)->getRecords();

        return Stat::make(
            __('pages.record_sets.widget.pr.title'),
            Tenant::numberFormat($records[$record->record_type_id] ?? null, Tenant::getWeightUnitLabel())
        )
            ->icon(Heroicon::OutlinedTrophy)
            ->description(__('pages.record_sets.widget.pr.description'))
            ->url(ViewProgression::getUrl(['record' => $record->recordType]));
    }

    protected function timeStat(RecordSet $recordSet)
    {
        return Stat::make(__('pages.record_sets.widget.time.title'), StopwatchCast::format($recordSet->time))
            ->description(__('pages.record_sets.widget.time.description'))
            ->icon(Heroicon::OutlinedClock);
    }
}
