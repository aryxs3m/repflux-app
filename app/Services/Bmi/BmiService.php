<?php

namespace App\Services\Bmi;

use App\Services\Settings\Enums\UnitType;

/**
 * @url https://en.wikipedia.org/wiki/Body_mass_index
 */
class BmiService
{
    /**
     * @throws \Exception
     */
    public function calculate(int $height, int $weight, UnitType $type = UnitType::METRIC): float
    {
        if (empty($height)) {
            throw new \Exception('Height is required');
        }

        if (empty($weight)) {
            throw new \Exception('Weight is required');
        }

        if ($type === UnitType::METRIC) {
            $height = $height / 100;
        }

        $conversion = 1;
        if ($type === UnitType::IMPERIAL) {
            $conversion = 703;
        }

        return round(($weight / pow($height, 2)) * $conversion, 1);
    }

    public static function getCategoryByBMI(float $bmi): BmiCategory
    {
        if ($bmi < 16) {
            return BmiCategory::SEVERE_UNDERWEIGHT;
        }

        if ($bmi < 17) {
            return BmiCategory::MODERATE_UNDERWEIGHT;
        }

        if ($bmi < 18.5) {
            return BmiCategory::MILD_UNDERWEIGHT;
        }

        if ($bmi < 25) {
            return BmiCategory::NORMAL;
        }

        if ($bmi < 30) {
            return BmiCategory::OVERWEIGHT;
        }

        if ($bmi < 35) {
            return BmiCategory::OBESE_CLASS_I;
        }

        if ($bmi < 40) {
            return BmiCategory::OBESE_CLASS_II;
        }

        return BmiCategory::OBESE_CLASS_III;
    }

    public static function getLabelByBmiCategory(BmiCategory $category): string
    {
        return __('bmi.categories.'.$category->value);
    }
}
