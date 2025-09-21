<?php

namespace Feature\Commands;

use App\Models\User;
use App\Services\MeasurementNotifier;
use Mockery\MockInterface;
use Tests\TestCase;

class OutdatedMeasurementNotifierTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        User::truncate();
    }

    public function test_can_ignore_users_when_no_notification_allowed()
    {
        User::factory()->create([
            'notify_measurement_weight' => false,
            'notify_measurement_body' => false,
        ]);

        $this->instance(
            MeasurementNotifier::class,
            \Mockery::mock(MeasurementNotifier::class, function (MockInterface $mock) {
                $mock->shouldNotReceive('sendBodyNotification');
                $mock->shouldNotReceive('sendWeightNotification');
            })
        );

        $this->artisan('app:outdated-measurement-notifier')
            ->assertExitCode(0)
            ->assertSuccessful()
            ->assertOk();
    }

    public function test_can_try_weight_notification_sending()
    {
        User::factory()->create([
            'notify_measurement_weight' => true,
            'notify_measurement_body' => false,
        ]);

        $this->instance(
            MeasurementNotifier::class,
            \Mockery::mock(MeasurementNotifier::class, function (MockInterface $mock) {
                $mock->shouldNotReceive('sendBodyNotification');
                $mock->shouldReceive('sendWeightNotification');
            })
        );

        $this->artisan('app:outdated-measurement-notifier')
            ->assertExitCode(0)
            ->assertSuccessful()
            ->assertOk();
    }

    public function test_can_try_body_notification_sending()
    {
        User::factory()->create([
            'notify_measurement_weight' => false,
            'notify_measurement_body' => true,
        ]);

        $this->instance(
            MeasurementNotifier::class,
            \Mockery::mock(MeasurementNotifier::class, function (MockInterface $mock) {
                $mock->shouldReceive('sendBodyNotification');
                $mock->shouldNotReceive('sendWeightNotification');
            })
        );

        $this->artisan('app:outdated-measurement-notifier')
            ->assertExitCode(0)
            ->assertSuccessful()
            ->assertOk();
    }
}
