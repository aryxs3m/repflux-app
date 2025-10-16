<?php

namespace App\Jobs;

use App\Models\UserFeedback;
use App\Services\YouTrack;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Sentry;
use Spatie\DiscordAlerts\Facades\DiscordAlert;

class FeedbackSendJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(private readonly UserFeedback $feedback) {}

    public function handle(): void
    {
        try {
            /** @var YouTrack $youTrack */
            $youTrack = app(YouTrack::class);

            $youTrack->createIssue(
                'Feedback #'.$this->feedback->id.' - '.ucfirst($this->feedback->type),
                '**User:** '.sprintf('%s (%s)', $this->feedback->user->name, $this->feedback->user->id)."\n".
                "**Message:**\n\n".$this->feedback->message
            );
        } catch (\Throwable $throwable) {
            Sentry::captureException($throwable);
        }

        try {
            DiscordAlert::message('Feedback #'.$this->feedback->id.' created!', [
                [
                    'title' => $this->feedback->type,
                    'description' => $this->feedback->message,
                    'color' => '#000000',
                    'author' => [
                        'name' => $this->feedback->user->name,
                        'url' => config('app.url'),
                    ],
                ],
            ]);
        } catch (\Throwable $throwable) {
            Sentry::captureException($throwable);
        }
    }
}
