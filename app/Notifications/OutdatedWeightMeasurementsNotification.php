<?php

namespace App\Notifications;

use App\Models\Weight;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OutdatedWeightMeasurementsNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(private readonly Weight $measurement)
    {
        app()->setLocale($this->measurement->user->language);
    }

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject(__('notifications.outdated-weight-measurements.subject'))
            ->greeting(__('notifications.greeting'))
            ->line(__('notifications.outdated-weight-measurements.body', ['ago' => $this->measurement->measured_at->diffForHumans()]))
            ->action(
                __('notifications.outdated-weight-measurements.measure_now'),
                url(route('filament.app.resources.weights.create', ['tenant' => $this->measurement->tenant->id]))
            );
    }

    public function toArray($notifiable): array
    {
        return [];
    }
}
