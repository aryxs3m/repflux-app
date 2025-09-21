<?php

namespace App\Filament\Resources\WeightResource\Widgets;

use App\Models\Weight;
use App\Services\Bmi\BmiService;
use App\Services\Settings\Tenant;
use App\Utilities\Trend;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class WeightStats extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        $this->getWeeklyWeightProgression();
        $bmiStat = $this->getBmiStat();

        return array_merge($this->getWeeklyWeightProgression(), [$bmiStat]);
    }

    protected function getWeeklyWeightProgression(): array
    {
        $records = Weight::query()
            ->where('user_id', auth()->user()->id)
            ->where('tenant_id', Tenant::getTenant()->id)
            ->orderBy('measured_at', 'desc')
            ->limit(2)
            ->get();

        if ($records->count() < 2) {
            return [];
        }

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

        $dailyTrend = $weeklyTrend / 7;
        $weightRecord = Weight::query()
            ->where('user_id', auth()->user()->id)
            ->where('tenant_id', Tenant::getTenant()->id)
            ->orderBy('measured_at', 'desc')
            ->limit(1)
            ->get()
            ->last();
        $currentWeight = $weightRecord->weight;
        $neededChange = ($currentWeight - auth()->user()->weight_target) / $dailyTrend;
        if ($neededChange > 1) {
            $neededChange = '-';
        }

        $neededChange *= -1;

        return [
            Stat::make(__('pages.weight.widgets.weekly_change'), Tenant::numberFormat($weeklyTrend, Tenant::getWeightUnitLabel())),
            Stat::make(__('pages.weight.widgets.monthly_change'), Tenant::numberFormat($monthlyTrend, Tenant::getWeightUnitLabel())),
            Stat::make(__('pages.weight.widgets.days_until_target'), Tenant::numberFormat($neededChange)),
        ];
    }

    protected function getBmiStat(): ?Stat
    {
        $weightRecord = Weight::query()
            ->where('user_id', auth()->user()->id)
            ->where('tenant_id', Tenant::getTenant()->id)
            ->orderBy('measured_at', 'desc')
            ->limit(1)
            ->get()
            ->last();

        if (! $weightRecord || empty(auth()->user()->height)) {
            return Stat::make('BMI', 'N/A')
                ->description(__('pages.weight.widgets.no_weight_recorded'));
        }

        $bmiService = app(BmiService::class);
        $bmi = $bmiService->calculate(
            auth()->user()->height,
            $weightRecord->weight,
            Tenant::getUnitType()
        );

        return Stat::make('BMI', $bmi)
            ->description(BmiService::getLabelByBmiCategory(BmiService::getCategoryByBMI($bmi)));
    }
}
