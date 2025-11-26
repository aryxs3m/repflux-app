<?php

namespace Feature\Commands;

use App\Services\InvitationService;
use Mockery\MockInterface;
use Tests\TestCase;

class RemoveExpiredInvitationsTest extends TestCase
{
    public function test_can_call_service()
    {
        $this->instance(
            InvitationService::class,
            \Mockery::mock(InvitationService::class, function (MockInterface $mock) {
                $mock->expects('removeExpiredInvitations')->once();
            })
        );

        $this->artisan('app:remove-expired-invitations')
            ->assertExitCode(0)
            ->assertSuccessful()
            ->expectsOutput('Removed expired invitations.')
            ->assertOk();
    }
}
