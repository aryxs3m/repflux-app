<?php

namespace App\Filament\Abstract\Schema;

use Filament\Tables\Table;

abstract class AbstractTableSchema
{
    abstract public static function configure(Table $table): Table;
}
