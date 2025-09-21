<?php

namespace App\Services\Settings;

use App\Models\Tenant;
use App\Models\User;
use App\Services\Settings\Enums\UnitType;
use Filament\Facades\Filament;

class TenantSettingsService
{
    public function getTenant(): ?Tenant
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return Filament::getTenant();
    }

    public function canAdminister(?User $user = null): bool
    {
        if ($user === null) {
            $user = auth()->user();
        }

        return $this->getTenant()
            ->users()
            ->where('id', $user->id)
            ->first()
            ->pivot
            ->is_admin ?? false;
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

    public function numberFormat(int|float $number, $suffix = null): string
    {
        $format = number_format($number, 2, ',', '');

        if ($suffix !== null) {
            $format .= ' ' . $suffix;
        }

        return $format;
    }

    public function removeUser(User $user): void
    {
        $this->getTenant()->users()->detach($user);
    }
}
