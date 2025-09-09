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
            ->subject('gymBro invitation')
            ->greeting('Hi!')
            ->line('You have been invited to "'.$this->invite->tenant->name.'" in gymBro.')
            ->action('Accept Invite', url(route('invite.join', ['hash' => $this->invite->hash])));
    }

    public function toArray($notifiable): array
    {
        return [];
    }
}
