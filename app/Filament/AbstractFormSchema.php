<?php

namespace App\Filament;

use Filament\Schemas\Schema;

abstract class AbstractFormSchema
{
    abstract public static function configure(Schema $schema): Schema;
}
