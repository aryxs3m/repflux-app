<?php

namespace App\Filament\Resources\WorkoutResource\Widgets;

use App\Models\Workout;
use App\Services\Gamification\GamifiedSize;
use Filament\Widgets\Widget;

class WorkoutSummary extends Widget
{
    protected string $view = 'filament.resources.workout-resource.widgets.workout-summary';

    protected int|string|array $columnSpan = 'full';

    public string $totalMove = 'nothing';

    public Workout $record;

    public function mount(): void
    {
        $this->totalMove = GamifiedSize::get($this->record->calc_total_weight);
    }
}
