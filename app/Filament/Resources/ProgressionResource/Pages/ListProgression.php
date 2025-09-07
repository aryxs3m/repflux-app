<?php

namespace App\Filament\Resources\ProgressionResource\Pages;

use App\Filament\Resources\ProgressionResource;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Contracts\Support\Htmlable;

class ListProgression extends ListRecords
{
    protected static string $resource = ProgressionResource::class;

    public function getTitle(): string|Htmlable
    {
        return __('pages.progression.list_title');
    }
}
