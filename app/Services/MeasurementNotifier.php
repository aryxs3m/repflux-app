<?php

namespace App\Services;

use App\Models\Measurement;
use App\Models\User;
use App\Models\Weight;
use App\Notifications\OutdatedBodyMeasurementsNotification;
use App\Notifications\OutdatedWeightMeasurementsNotification;
use Carbon\Carbon;

class MeasurementNotifier
{
    const NOTIFY_DAYS = 30;

    public function sendBodyNotification(User $user): void
    {
        $measurement = Measurement::query()
            ->where('user_id', $user->id)
            ->orderBy('measured_at', 'desc')
            ->limit(1)
            ->get()
            ->first();

        if (! $measurement) {
            return;
        }

        if (round($measurement->measured_at->diffInDays(Carbon::now()->startOfDay())) == $user->notify_measurement_body_days) {
            $user->notify(new OutdatedBodyMeasurementsNotification($measurement));
        }
    }

    public function sendWeightNotification(User $user): void
    {
        $measurement = Weight::query()
            ->where('user_id', $user->id)
            ->orderBy('measured_at', 'desc')
            ->limit(1)
            ->get()
            ->first();

        if (! $measurement) {
            return;
        }

        if (round($measurement->measured_at->diffInDays(Carbon::now()->startOfDay())) == $user->notify_measurement_weight_days) {
            $user->notify(new OutdatedWeightMeasurementsNotification($measurement));
        }
    }
}
