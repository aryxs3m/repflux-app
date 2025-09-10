<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Services\MeasurementNotifier;
use Illuminate\Console\Command;

class OutdatedMeasurementNotifier extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:outdated-measurement-notifier';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sends notifications about outdated measurements';

    /**
     * Execute the console command.
     */
    public function handle(MeasurementNotifier $service): void
    {
        User::query()
            ->where('notify_measurement_body', '=', 1)
            ->each(function (User $user) use ($service) {
                $this->line('Checking '.$user->name.'...');
                $service->sendBodyNotification($user);
            });

        User::query()
            ->where('notify_measurement_weight', '=', 1)
            ->each(function (User $user) use ($service) {
                $this->line('Checking '.$user->name.'...');
                $service->sendWeightNotification($user);
            });
    }
}
