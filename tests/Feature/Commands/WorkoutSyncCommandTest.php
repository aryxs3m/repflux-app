<?php

namespace Feature\Commands;

use App\Models\RecordSet;
use App\Services\Workout\WorkoutService;
use Mockery\MockInterface;
use Tests\TestCase;

class WorkoutSyncCommandTest extends TestCase
{
    public function test_can_call_service_successfully()
    {
        RecordSet::factory()->create();

        $this->instance(
            WorkoutService::class,
            \Mockery::mock(WorkoutService::class, function (MockInterface $mock) {
                $mock->expects('sync')->once();
            })
        );

        $this->artisan('workout:sync')
            ->assertExitCode(0)
            ->assertSuccessful()
            ->assertOk();
    }

    public function test_can_call_service_successfully_even_with_error()
    {
        RecordSet::factory()->create();

        $this->instance(
            WorkoutService::class,
            \Mockery::mock(WorkoutService::class, function (MockInterface $mock) {
                $mock
                    ->shouldReceive('sync')
                    ->atLeast()->once()
                    ->andThrows(\Exception::class, 'Mock error');
            })
        );

        $this->artisan('workout:sync')
            ->expectsOutput('1: Mock error')
            ->assertExitCode(0)
            ->assertSuccessful()
            ->assertOk();
    }
}
