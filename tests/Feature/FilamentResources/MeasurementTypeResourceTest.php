<?php

namespace Feature\FilamentResources;

use App\Filament\Resources\MeasurementTypeResource;
use Filament\Resources\Resource;
use Tests\Feature\FilamentResources\BaseResourceTestCase;

class MeasurementTypeResourceTest extends BaseResourceTestCase
{
    protected static string|Resource $resource = MeasurementTypeResource::class;
}
