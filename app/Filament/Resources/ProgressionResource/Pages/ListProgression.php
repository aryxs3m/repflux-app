<?php

namespace App\Filament\Resources\ProgressionResource\Pages;

use App\Filament\Resources\ProgressionResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListProgression extends ListRecords
{
    protected static string $resource = ProgressionResource::class;
    protected static ?string $title = 'Progression Reports';
}
