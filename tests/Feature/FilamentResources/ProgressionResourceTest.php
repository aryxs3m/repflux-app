<?php

namespace Feature\FilamentResources;

use App\Filament\Resources\ProgressionResource;
use Filament\Resources\Resource;
use Tests\Feature\FilamentResources\BaseResourceTestCase;

class ProgressionResourceTest extends BaseResourceTestCase
{
    protected static string|Resource $resource = ProgressionResource::class;

    protected static bool $hasCreatePage = false;

    protected static bool $hasEditPage = false;
}
