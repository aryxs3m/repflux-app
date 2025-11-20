<?php

namespace App\Filament\Abstract\Page;

use Filament\Resources\Pages\CreateRecord;

abstract class AbstractCreateRecord extends CreateRecord
{
    /**
     * After save, redirect to the resource list/index.
     */
    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }
}
