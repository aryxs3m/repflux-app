<?php

namespace App\Utilities;

use BackedEnum;
use Exception;

class EnumDescriptor
{
    /**
     * @throws Exception
     */
    public static function getAll($enum): array
    {
        $values = array_map(fn (BackedEnum $value) => $value->value, $enum::cases());
        $descriptions = array_map(fn (HasDescription $value) => $value->getDescription(), $enum::cases());

        return array_combine($values, $descriptions);
    }
}
