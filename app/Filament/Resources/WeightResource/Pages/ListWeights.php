<?php

namespace App\Filament\Resources\WeightResource\Pages;

use App\Filament\Resources\WeightResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListWeights extends ListRecords
{
    protected static string $resource = WeightResource::class;

    protected function getHeaderWidgets(): array
    {
        return [
            WeightResource\Widgets\WeightChart::class,
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
