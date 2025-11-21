<?php

namespace App\Notifications;

use App\Filament\Resources\WorkoutResource\Pages\ViewWorkout;
use App\Models\Workout;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Collection;

class MissingWorkoutRecordNotification extends Notification
{
    public function __construct(private readonly Workout $workout, private readonly Collection $records) {}

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject(__('notifications.workout.missing_records.subject'))
            ->greeting(__('notifications.greeting'))
            ->line(__('notifications.workout.missing_records.body', ['count' => $this->records->count()]))
            ->line(__('notifications.workout.missing_records.body_details', ['list' => implode(', ', $this->records->pluck('name')->toArray())]))
            ->action(
                __('notifications.workout.missing_records.button'),
                ViewWorkout::getUrl([
                    'tenant' => $this->workout->tenant->id,
                    'record' => $this->workout->id,
                ])
            );
    }

    public function toArray($notifiable): array
    {
        return [];
    }
}
