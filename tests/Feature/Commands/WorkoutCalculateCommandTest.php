<?php

namespace Feature\Commands;

use App\Models\Workout;
use App\Services\Workout\WorkoutService;
use Mockery\MockInterface;
use Tests\TestCase;

class WorkoutCalculateCommandTest extends TestCase
{
    public function test_can_call_service()
    {
        $this->instance(
            WorkoutService::class,
            \Mockery::mock(WorkoutService::class, function (MockInterface $mock) {
                $mock->expects('calculateValues')->once();
            })
        );

        Workout::factory()->create();

        $this->artisan('workout:calculate')
            ->assertExitCode(0)
            ->assertSuccessful()
            ->assertOk();
    }
}
