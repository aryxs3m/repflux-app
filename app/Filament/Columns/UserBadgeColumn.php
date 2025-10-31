<?php

namespace App\Filament\Columns;

use Filament\Tables\Columns\TextColumn;

class UserBadgeColumn extends TextColumn
{
    public static function make(?string $name = null): static
    {
        return parent::make($name)
            ->badge()
            ->formatStateUsing(fn ($state) => $state->name)
            ->color(fn ($state) => $state->color);
    }
}
