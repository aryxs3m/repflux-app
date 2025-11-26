<?php

namespace App\Services;

class OneRepMaxCalculator
{
    public function getBrzyckiOneRepMax(float $weight, int $reps): float
    {
        return $weight * (36 / (37 - $reps));
    }

    public function getEpleyOneRepMax(float $weight, int $reps): float
    {
        return $weight * (1 + $reps / 30);
    }
}
