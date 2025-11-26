<?php

namespace App\Services\Settings;

use Illuminate\Support\Facades\Facade;

/**
 * @see TenantSettingsService
 */
class Tenant extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return TenantSettingsService::class;
    }
}
