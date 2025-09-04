<?php

namespace App\Observers;

use App\Models\MeasurementType;
use App\Observers\Traits\ClearsMeasurementCache;

class MeasurementTypeCacheObserver
{
    use ClearsMeasurementCache;

    // FIXME: only clear cache for users that have measurements of this type

    public function created(MeasurementType $measurementType): void
    {
        \Cache::tags('measurement-types')->flush();
    }

    public function updated(MeasurementType $measurementType): void
    {
        \Cache::tags('measurement-types')->flush();
    }

    public function deleted(MeasurementType $measurementType): void
    {
        \Cache::tags('measurement-types')->flush();
    }

    public function restored(MeasurementType $measurementType): void
    {
        \Cache::tags('measurement-types')->flush();
    }
}
