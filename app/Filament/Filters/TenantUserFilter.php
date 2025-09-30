<?php

namespace App\Filament\Filters;

use App\Services\Settings\Tenant;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;

class TenantUserFilter extends SelectFilter
{
    public static function make(?string $name = 'user'): static
    {
        return parent::make($name)
            ->label(__('columns.name'))
            ->relationship('user', 'name', fn (Builder $query) => $query->whereAttachedTo(Tenant::getTenant(), 'tenants'));
    }

    public function defaultSelf(): static
    {
        return $this->default(auth()->user()->id);
    }
}
