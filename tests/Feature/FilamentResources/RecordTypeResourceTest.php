<?php

namespace Feature\FilamentResources;

use App\Filament\Resources\RecordTypeResource;
use Filament\Resources\Resource;
use Tests\Feature\FilamentResources\BaseResourceTestCase;

class RecordTypeResourceTest extends BaseResourceTestCase
{
    protected static string|Resource $resource = RecordTypeResource::class;
}
