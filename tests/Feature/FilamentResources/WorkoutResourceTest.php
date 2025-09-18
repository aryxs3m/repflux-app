<?php

namespace Feature\FilamentResources;

use App\Filament\Resources\WorkoutResource;
use Filament\Resources\Resource;
use Tests\Feature\FilamentResources\BaseResourceTestCase;

class WorkoutResourceTest extends BaseResourceTestCase
{
    protected static string|Resource $resource = WorkoutResource::class;

    protected static bool $hasCreatePage = false;
}
