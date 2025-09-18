<?php

namespace App\Filament\Resources\WorkoutResource\Pages;

use App\Filament\Resources\WorkoutResource;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Contracts\Support\Htmlable;

class ListWorkouts extends ListRecords
{
    protected static string $resource = WorkoutResource::class;

    public function getTitle(): string|Htmlable
    {
        return __('pages.workouts.list_title');
    }

    protected function getHeaderActions(): array
    {
        return [
        ];
    }
}
