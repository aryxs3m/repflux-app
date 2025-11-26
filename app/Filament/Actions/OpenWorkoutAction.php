<?php

namespace App\Filament\Actions;

use App\Filament\Resources\WorkoutResource\Pages\ViewWorkout;
use App\Models\RecordSet;
use App\Models\Workout;
use App\Services\Settings\Tenant;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Support\Icons\Heroicon;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Model;

/**
 * Opens the last Workout or if used on a RecordSet Edit or View page the Workout where the RecordSet belongs.
 */
class OpenWorkoutAction extends Action
{
    public function getRecord(bool $withDefault = true): Model|array|null
    {
        if ($this->record == null) {
            $this->record = Workout::query()
                ->where('tenant_id', '=', Tenant::getTenant()->id)
                ->orderBy('workout_at', 'desc')
                ->first();
        }

        return $this->record;
    }

    public function isVisible(): bool
    {
        return $this->getRecord() !== null;
    }

    public static function getDefaultName(): ?string
    {
        return 'workout';
    }

    public function getLabel(): string|Htmlable|null
    {
        return __('pages.record_sets.workout');
    }

    public function getIcon(BackedEnum|string|null $default = null): string|BackedEnum|Htmlable|null
    {
        return Heroicon::OutlinedBolt;
    }

    public function getUrl(): ?string
    {
        $workout = $this->getRecord();

        if ($workout instanceof RecordSet) {
            $workout = $workout->workout;
        }

        return ViewWorkout::getUrl(['record' => $workout]);
    }

    public function getColor(): string|array|null
    {
        return 'gray';
    }
}
