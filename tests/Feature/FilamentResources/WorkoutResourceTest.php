<?php

namespace Feature\FilamentResources;

use App\Filament\Resources\WorkoutResource;
use App\Models\Workout;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Model;
use Tests\Feature\FilamentResources\BaseResourceTestCase;

class WorkoutResourceTest extends BaseResourceTestCase
{
    protected static string|Resource $resource = WorkoutResource::class;

    protected function viewSchemaData(Model $model): array
    {
        /** @var Workout $model */
        return [
            'workout_at' => $model->workout_at,
            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at,
        ];
    }

    protected static bool $hasViewPage = true;
    protected static bool $hasCreatePage = false;
    protected static bool $hasEditPage = false; // only available in modal
}
