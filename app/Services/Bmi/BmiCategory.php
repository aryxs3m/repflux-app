<?php

namespace App\Services\Bmi;

enum BmiCategory: string
{
    case SEVERE_UNDERWEIGHT = 'severe_underweight';
    case MODERATE_UNDERWEIGHT = 'moderate_underweight';
    case MILD_UNDERWEIGHT = 'mild_underweight';
    case NORMAL = 'normal';
    case OVERWEIGHT = 'overweight';
    case OBESE_CLASS_I = 'obese_class_1';
    case OBESE_CLASS_II = 'obese_class_2';
    case OBESE_CLASS_III = 'obese_class_3';
}
