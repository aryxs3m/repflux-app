<?php

namespace Feature\FilamentResources;

use App\Filament\Resources\WeightResource;
use Filament\Resources\Resource;
use Tests\Feature\FilamentResources\BaseResourceTestCase;

class WeightResourceTest extends BaseResourceTestCase
{
    protected static string|Resource $resource = WeightResource::class;
}
