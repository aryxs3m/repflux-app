<?php

namespace App\Filament\Resources\WeightResource\Pages;

use App\Filament\Resources\WeightResource;
use Filament\Resources\Pages\CreateRecord;

class CreateWeight extends CreateRecord
{
    protected static string $resource = WeightResource::class;

    protected function getHeaderActions(): array
    {
        return [

        ];
    }
}
