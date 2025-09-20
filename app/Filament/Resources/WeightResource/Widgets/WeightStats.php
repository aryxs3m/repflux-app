<?php

namespace App\Filament\Resources\WeightResource\Widgets;

use App\Models\Weight;
use App\Services\Bmi\BmiService;
use App\Services\Settings\TenantSettings;
use App\Utilities\Trend;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class WeightStats extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        $this->getWeeklyWeightProgression();
        $bmiStat = $this->getBmiStat();

        return $this->getWeeklyWeightProgression() + [$bmiStat];
    }

    protected function getWeeklyWeightProgression()
    {
        $records = Weight::query()
            ->where('user_id', auth()->user()->id)
            ->where('tenant_id', TenantSettings::getTenant()->id)
            ->orderBy('measured_at', 'desc')
            ->limit(2)
            ->get();

        $weeklyTrend = Trend::calculate(
            $records,
            'weight',
            'measured_at',
            7
        );

        $monthlyTrend = Trend::calculate(
            $records,
            'weight',
            'measured_at',
            30
        );

        // TODO: translations
        return [
            Stat::make('Heti súlyváltozás', $weeklyTrend.' '.TenantSettings::getWeightUnitLabel()),
            Stat::make('Havi súlyváltozás', $monthlyTrend.' '.TenantSettings::getWeightUnitLabel()),
        ];
    }

    protected function getBmiStat(): ?Stat
    {
        $weightRecord = Weight::query()
            ->where('user_id', auth()->user()->id)
            ->where('tenant_id', TenantSettings::getTenant()->id)
            ->orderBy('measured_at', 'desc')
            ->limit(1)
            ->get()
            ->last();

        if (! $weightRecord) {
            return Stat::make('BMI', 'N/A')
                ->description(__('pages.weight.widgets.no_weight_recorded'));
        }

        if (empty(auth()->user()->height)) {
            return null;
        }

        $bmiService = app(BmiService::class);
        $bmi = $bmiService->calculate(
            auth()->user()->height,
            $weightRecord->weight,
            TenantSettings::getUnitType()
        );

        return Stat::make('BMI', $bmi)
            ->description(BmiService::getLabelByBmiCategory(BmiService::getCategoryByBMI($bmi)));
    }
}
