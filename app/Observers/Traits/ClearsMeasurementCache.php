<?php

namespace App\Observers\Traits;

trait ClearsMeasurementCache
{
    protected function clearMeasurementCache(int $userId = null): void
    {
        if ($userId === null) {
            $userId = auth()->id();
        }

        \Cache::forget($userId . '-measurement-stats');
    }
}
