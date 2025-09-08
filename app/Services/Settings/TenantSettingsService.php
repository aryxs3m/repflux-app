<?php

namespace App\Services\Settings;

use App\Models\Tenant;
use App\Services\Settings\Enums\UnitType;
use Filament\Facades\Filament;

class TenantSettingsService
{
    public function getTenant(): ?Tenant
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return Filament::getTenant();
    }

    public function getUnitType(): UnitType
    {
        return $this->getTenant()->unit_type;
    }

    public function getWeightUnitLabel(): string
    {
        return $this->getUnitType() === UnitType::METRIC ? 'kg' : 'lbs';
    }

    public function getLengthUnitLabel(): string
    {
        return $this->getUnitType() === UnitType::METRIC ? 'cm' : 'in';
    }
}
