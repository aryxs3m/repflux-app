<?php

namespace App\Filament;

use Filament\Tables\Table;

abstract class AbstractTableSchema
{
    abstract public static function configure(Table $table): Table;
}
