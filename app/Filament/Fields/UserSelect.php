<?php

namespace App\Filament\Fields;

use App\Services\Settings\Tenant;
use Filament\Forms\Components\Select;

class UserSelect extends Select
{
    public static function getDefaultName(): ?string
    {
        return 'user_id';
    }

    public static function make(?string $name = null): static
    {
        return parent::make($name)
            ->options(Tenant::getTenant()->users->pluck('name', 'id'))
            ->searchable()
            ->preload()
            ->required();
    }

    public function defaultSelf(): static
    {
        $this->default(auth()->user()->id);

        return $this;
    }

    public function defaultOther(): static
    {
        $this->default(Tenant::otherUser()?->id);

        return $this;
    }
}
