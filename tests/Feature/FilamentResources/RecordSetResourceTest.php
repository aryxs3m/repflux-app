<?php

namespace Feature\FilamentResources;

use App\Filament\Resources\RecordSetResource;
use App\Filament\Resources\RecordTypeResource\ExerciseType;
use App\Models\RecordSet;
use App\Models\RecordType;
use Exception;
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

    /**
     * @throws Exception
     */
    public function test_can_show_edit_page_for_cardio()
    {
        $type = RecordType::factory()->create(['name' => 'Cardio', 'exercise_type' => ExerciseType::CARDIO]);
        $recordSet = RecordSet::factory()->create(['record_type_id' => $type->id]);

        $this->test_can_show_edit_page($recordSet);
    }

    /**
     * @throws Exception
     */
    public function test_can_show_edit_page_for_other()
    {
        $type = RecordType::factory()->create(['name' => 'Other', 'exercise_type' => ExerciseType::OTHER]);
        $recordSet = RecordSet::factory()->create(['record_type_id' => $type->id]);

        $this->test_can_show_edit_page($recordSet);
    }
}
