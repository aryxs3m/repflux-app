<?php

namespace App\Filament\Resources\WeightResource\Pages;

use App\Filament\Resources\WeightResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Contracts\Support\Htmlable;

class ListWeights extends ListRecords
{
    protected static string $resource = WeightResource::class;

    public function getTitle(): string|Htmlable
    {
        return __('pages.weight.list_title');
    }

    protected function getHeaderWidgets(): array
    {
        return [
            WeightResource\Widgets\WeightStats::class,
            WeightResource\Widgets\WeightChart::class,
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label(__('pages.weight.add_weight')),
        ];
    }
}
