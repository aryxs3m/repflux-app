<?php

namespace App\Filament\Abstract\Schema;

use Filament\Schemas\Schema;

abstract class AbstractFormSchema
{
    abstract public static function configure(Schema $schema): Schema;
}
