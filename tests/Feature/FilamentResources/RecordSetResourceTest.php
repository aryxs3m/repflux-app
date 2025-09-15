<?php

namespace Feature\FilamentResources;

use App\Filament\Resources\RecordSetResource;
use App\Models\RecordSet;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Model;
use Tests\Feature\FilamentResources\BaseResourceTestCase;

class RecordSetResourceTest extends BaseResourceTestCase
{
    protected static string|Resource $resource = RecordSetResource::class;

    protected static bool $hasViewPage = true;

    protected function viewSchemaData(Model $model): array
    {
        /** @var RecordSet $model */
        return [
            'set_done_at' => $model->created_at,
            'user.name' => $model->user->name,
            'recordType.name' => $model->recordType->name,
            'recordType.recordCategory.name' => $model->recordType->recordCategory->name,
        ];
    }
}
