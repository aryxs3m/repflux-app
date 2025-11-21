<?php

use App\Console\Commands\OutdatedMeasurementNotifier;
use App\Console\Commands\RemoveExpiredInvitations;
use App\Console\Commands\WorkoutMissingRecordTypeCommand;

Schedule::command(RemoveExpiredInvitations::class)
    ->daily();

Schedule::command(OutdatedMeasurementNotifier::class)
    ->dailyAt('06:00');

Schedule::command(WorkoutMissingRecordTypeCommand::class)
    ->dailyAt('14:00');
