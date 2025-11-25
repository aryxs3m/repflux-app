<?php

namespace App\Services\Settings;

use App\Models\Tenant;
use App\Models\User;
use App\Services\Settings\Enums\UnitType;
use Filament\Facades\Filament;
use Illuminate\Validation\UnauthorizedException;

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

    public function authenticate($tenant, ?User $user = null): void
    {
        if ($user === null) {
            $user = auth()->user();
        }

        $tenant = Tenant::query()->find($tenant);

        if (!$user->canAccessTenant($tenant)) {
            throw new UnauthorizedException("You don't have permission to access this tenant.");
        }
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

    public function numberFormat(int|float|null|string $number, $suffix = null): string
    {
        if ($number === null) {
            return 'N/A';
        }

        if (is_string($number)) {
            return $number;
        }

        $user = auth()->user();

        $format = number_format(
            $number,
            $user->number_format_decimals,
            $user->number_format_decimal_separator,
            $user->number_format_thousands_separator
        );

        if ($suffix !== null) {
            $format .= ' '.$suffix;
        }

        return $format;
    }

    public function removeUser(User $user): void
    {
        $this->getTenant()->users()->detach($user);
    }

    /**
     * Returns the next user in the tenant (that is not the current one), or null if there is no other user.
     */
    public function otherUser(): ?User
    {
        return $this->getTenant()->users()->where('id', '!=', auth()->id())->first();
    }
}
