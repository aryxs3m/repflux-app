<?php

namespace App\Notifications;

use App\Models\Invite;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TenantUserInviteNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(private readonly Invite $invite) {}

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject(__('notifications.invite.subject'))
            ->greeting(__('notifications.greeting'))
            ->line(__('notifications.invite.body', ['tenant' => $this->invite->tenant->name]))
            ->action(__('notifications.invite.accept_invite'), url(route('invite.join', ['hash' => $this->invite->hash])));
    }

    public function toArray($notifiable): array
    {
        return [];
    }
}
