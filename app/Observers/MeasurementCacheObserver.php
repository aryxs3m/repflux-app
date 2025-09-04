<?php

namespace App\Observers;

use App\Models\Measurement;
use App\Observers\Traits\ClearsMeasurementCache;

class MeasurementCacheObserver
{
    use ClearsMeasurementCache;

    public function created(Measurement $measurement): void
    {
        $this->clearMeasurementCache($measurement->user->id);
    }

    public function updated(Measurement $measurement): void
    {
        $this->clearMeasurementCache($measurement->user->id);
    }

    public function deleted(Measurement $measurement): void
    {
        $this->clearMeasurementCache($measurement->user->id);
    }

    public function restored(Measurement $measurement): void
    {
        $this->clearMeasurementCache($measurement->user->id);
    }
}
