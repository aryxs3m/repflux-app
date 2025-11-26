<?php

namespace Tests\Unit\Services;

use App\Models\RecordSet;
use App\Services\RecordSetSessionService;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\TestCase;
use Mockery\MockInterface;
use stdClass;

class RecordSetSessionServiceTest extends TestCase
{
    public function test_can_return_null_on_no_last_data(): void
    {
        $service = app(RecordSetSessionService::class);

        $this->assertFalse($service->hasLastRecord());

        $this->assertNull($service->getLastRecordCategoryId());
        $this->assertNull($service->getLastRecordTypeId());
        $this->assertNull($service->getLastSetDone());
    }

    public function test_can_return_last_values_when_has_data(): void
    {
        $service = app(RecordSetSessionService::class);

        /** @var RecordSet $recordSet */
        $recordSet = $this->mock(RecordSet::class, function (MockInterface $mock) {
            $recordType = new stdClass;
            $recordType->record_category_id = 2;

            $mock->shouldReceive('getAttribute')
                ->with('record_type_id')
                ->andReturn(1);

            $mock->shouldReceive('getAttribute')
                ->with('recordType')
                ->andReturn($recordType);

            $mock->expects('getAttribute')
                ->with('set_done_at')
                ->andReturn(Carbon::now()->startOfDay());
        });

        $service->updateLastOptions($recordSet);

        $this->assertTrue($service->hasLastRecord());

        $this->assertEquals(1, $service->getLastRecordTypeId());
        $this->assertEquals(2, $service->getLastRecordCategoryId());
        $this->assertEquals(Carbon::now()->startOfDay(), $service->getLastSetDone());
    }
}
