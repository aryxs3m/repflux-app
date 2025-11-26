<?php

namespace Feature\FilamentResources;

use App\Filament\Resources\MeasurementResource;
use Filament\Resources\Resource;
use Tests\Feature\FilamentResources\BaseResourceTestCase;

class MeasurementResourceTest extends BaseResourceTestCase
{
    protected static string|Resource $resource = MeasurementResource::class;
}
