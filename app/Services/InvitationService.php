<?php

namespace App\Services;

use App\Models\Invite;
use App\Models\Tenant;
use App\Notifications\TenantUserInviteNotification;
use Carbon\Carbon;
use Illuminate\Support\Facades\Notification;
use Random\RandomException;

class InvitationService
{
    /**
     * @throws RandomException
     */
    protected function createInvitation(Tenant $tenant): Invite
    {
        return Invite::query()->create([
            'hash' => bin2hex(random_bytes(18)),
            'tenant_id' => $tenant->id,
            'expires_at' => Carbon::now(1)->addDays(7),
        ]);
    }

    public function getInvitationUrl(Invite $invite): string
    {
        return route('invite.join', ['hash' => $invite->hash]);
    }

    public function inviteByEmail(Tenant $tenant, string $email): void
    {
        $invitation = $this->createInvitation($tenant);

        Notification::route('mail', $email)
            ->notify(new TenantUserInviteNotification($invitation));
    }

    public function closeInvitation(Invite $invite): void
    {
        $invite->delete();
    }

    public function removeExpiredInvitations(): void
    {
        Invite::query()->where('expires_at', '<', Carbon::now())->delete();
    }
}
