<?php

namespace App\Services;

class ArrayManipulationClass
{
    public static function removeFalseValues($array)
    {
        return array_filter($array, fn ($value) => $value !== false);
    }
}
