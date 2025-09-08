<?php

namespace App\Filament\Resources\WeightResource\Widgets;

use App\Models\Weight;
use App\Services\Bmi\BmiService;
use App\Services\Settings\TenantSettings;
use Filament\Events\TenantSet;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class BmiWidget extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        $bmiStat = $this->getBmiStat();

        return $bmiStat ? [$bmiStat] : [];
    }

    protected function getBmiStat(): ?Stat
    {
        $weightRecord = Weight::query()
            ->where('user_id', auth()->user()->id)
            ->where('tenant_id', TenantSettings::getTenant()->id)
            ->orderBy('id', 'desc')
            ->limit(1)
            ->get()
            ->last();

        if (!$weightRecord) {
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
