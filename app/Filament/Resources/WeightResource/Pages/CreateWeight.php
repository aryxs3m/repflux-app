<?php

namespace App\Filament\Resources\WeightResource\Pages;

use App\Filament\Resources\WeightResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Contracts\Support\Htmlable;

class CreateWeight extends CreateRecord
{
    protected static string $resource = WeightResource::class;

    public function getTitle(): string|Htmlable
    {
        return __('pages.weight.create_title');
    }

    protected function getHeaderActions(): array
    {
        return [

        ];
    }
}
