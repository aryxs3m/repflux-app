<?php

namespace App\Services\Gamification;

abstract class GamifiedSize
{
    protected const THINGS = [
        1 => 'Liter of water',
        2 => 'Chihuahua',
        3 => 'Newborn baby',
        4 => 'Bowling ball',
        5 => 'Average house cat',
        7 => 'Car tire',
        10 => 'Standard barbell (empty)',
        15 => 'Average microwave oven',
        20 => 'Standard suitcase (packed)',
        25 => 'Golden Retriever',
        30 => 'Average 10-year-old child',
        45 => 'Olympic barbell with two 20kg plates',
        50 => 'Average washing machine',
        70 => 'Adult male human',
        75 => 'Large German Shepherd',
        80 => 'Vending machine',
        100 => 'Average adult male lion',
        120 => 'Standard refrigerator',
        140 => 'Baby grand piano',
        150 => 'Grizzly bear',
        180 => 'Adult male gorilla',
        200 => 'Upright piano',
        250 => 'Refrigerated vending machine',
        300 => 'Adult male polar bear',
        350 => 'Large vending machine (fully stocked)',
        400 => 'Adult male tiger (large)',
        450 => 'Small motorcycle',
        500 => 'Grand piano',
        600 => 'Adult male moose',
        680 => 'Smart ForTwo car',
        750 => 'Average horse',
        800 => 'Dairy cow',
        900 => 'Standard motorcycle',
        1000 => 'Small car (empty)',
        1010 => '1992 Toyota Corolla',
        1200 => 'Horse (large)',
        1360 => 'Fiat 500',
        1500 => 'Mid-size sedan',
        1800 => 'Ford F-150 pickup',
        2000 => 'Large SUV',
        2200 => 'Hippopotamus',
        2500 => 'Full-size pickup truck',
        3000 => 'African elephant',
        3500 => 'Dump truck (empty)',
        4000 => 'Adult male elephant (large)',
        5000 => 'Adult male orca (killer whale)',
        6000 => 'African elephant bull (large)',
        7000 => 'School bus (empty)',
        8000 => 'Garbage truck (empty)',
        10000 => 'City bus',
        12000 => 'Fire truck',
        15000 => 'Humpback whale',
        20000 => 'Loaded semi-truck',
        25000 => 'Adult male sperm whale',
        30000 => 'Loaded cement mixer truck',
        40000 => 'Fully loaded semi-truck and trailer',
        50000 => 'M1 Abrams tank',
        60000 => 'Boeing 737 (empty)',
        80000 => 'Adult blue whale',
        100000 => 'Space Shuttle (empty)',
        150000 => 'Fully loaded blue whale',
        200000 => 'Boeing 747 (empty)',
        300000 => 'Small cruise ship',
        500000 => 'Large commercial airliner (fully loaded)',
        1000000 => 'Eiffel Tower (metal structure)',
        6000000 => 'Statue of Liberty (total monument)',
    ];

    public static function get(int|float $value): string
    {
        if ($value === 0) {
            return 'Nothing';
        }

        $index = array_last(array_filter(array_keys(self::THINGS), fn ($item) => $item <= $value));

        if ($index === null) {
            return 'Nothing';
        }

        $item = self::THINGS[$index];
        $itemValue = round($value / $index, 2);

        return sprintf('%s %s', $itemValue, $item);
    }
}
