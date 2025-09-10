<?php

use App\Console\Commands\OutdatedMeasurementNotifier;
use App\Console\Commands\RemoveExpiredInvitations;

Schedule::command(RemoveExpiredInvitations::class)
    ->daily();

Schedule::command(OutdatedMeasurementNotifier::class)
    ->dailyAt('06:00');
