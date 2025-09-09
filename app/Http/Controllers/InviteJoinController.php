<?php

namespace App\Http\Controllers;

use App\Models\Invite;
use App\Services\InvitationService;
use Filament\Notifications\Notification;
use Filament\Pages\Dashboard;
use Illuminate\Http\Request;

class InviteJoinController extends Controller
{
    public function join(Request $request, InvitationService $service)
    {
        $invitation = Invite::query()
            ->where('hash', $request->hash)
            ->first();

        if ($invitation === null) {
            return view('invitation.error-invite-not-found');
        }

        if ($invitation->expires_at->isPast()) {
            return view('invitation.error-expired');
        }

        if ($invitation->tenant === null) {
            return view('invitation.error-tenant-not-found');
        }

        $invitation->tenant->users()->attach(auth()->id());

        Notification::make()
            ->title(__('pages.tenancy.users.notifications.join.success.title'))
            ->success()
            ->send();

        $service->closeInvitation($invitation);

        return redirect()
            ->to(Dashboard::getUrl([
                'tenant' => $invitation->tenant->id,
            ]));
    }
}
