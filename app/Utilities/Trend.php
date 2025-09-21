<?php

namespace App\Utilities;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

abstract class Trend
{
    public static function calculate(array|Collection $models, string $valueField, string $dateField,
        int $progressionPerDay = 1): float
    {
        /** @var Model[] $models */
        $firstValue = $models[0]->getAttribute($valueField);
        $secondValue = $models[1]->getAttribute($valueField);

        /** @var Carbon $firstDate */
        $firstDate = $models[0]->getAttribute($dateField);

        /** @var Carbon $secondDate */
        $secondDate = $models[1]->getAttribute($dateField);

        $diff = $firstDate->diffInDays($secondDate);
        $newerFirst = $diff < 0;

        if ($newerFirst) {
            $oneDayTrend = ($secondValue - $firstValue) / $diff * 1.0;
        } else {
            $oneDayTrend = ($firstValue - $secondValue) / $diff * (-1.0);
        }

        return $oneDayTrend * $progressionPerDay;
    }
}
