<?php

namespace App\Filament\Columns;

use Filament\Tables\Columns\TextColumn;

class ShortDateColumn extends TextColumn {
    public static function make(?string $name = null): static
    {
        return parent::make($name)
            ->date('M j (D)');
    }
}
