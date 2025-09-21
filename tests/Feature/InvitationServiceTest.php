<?php

namespace Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Invite;
use App\Models\Tenant;
use App\Notifications\TenantUserInviteNotification;
use App\Services\InvitationService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class InvitationServiceTest extends TestCase
{
    /**
     * @throws \Exception
     */
    public function test_can_invite_by_email(): void
    {
        Notification::fake();
        $service = app(InvitationService::class);
        $tenant = Tenant::factory()->create();

        $service->inviteByEmail($tenant, 'test@repflux.app');

        $this->assertDatabaseCount('invites', 1);
        $this->assertDatabaseHas('invites', [
            'tenant_id' => $tenant->id,
            'expires_at' => Carbon::now(1)->addDays(7),
        ]);

        Notification::assertSentTimes(TenantUserInviteNotification::class, 1);
    }

    public function test_can_get_invitation_url()
    {
        $service = app(InvitationService::class);
        $invite = Invite::factory()->create();

        $url = $service->getInvitationUrl($invite);

        $this->assertNotEmpty($url);
        $this->assertStringContainsString($invite->hash, $url);
    }

    public function test_can_close_invitation()
    {
        $service = app(InvitationService::class);
        $invite = Invite::factory()->create();

        $service->closeInvitation($invite);

        $this->assertDatabaseCount('invites', 0);
    }

    public function test_can_remove_expired_invitations()
    {
        $service = app(InvitationService::class);
        Invite::factory()->create([
            'expires_at' => Carbon::now(1)->subDays(1),
        ]);

        $service->removeExpiredInvitations();

        $this->assertDatabaseCount('invites', 0);
    }
}
