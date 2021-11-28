<?php

namespace App\Helpers;

/**
 * Class ArrayHelper
 * @package App\Helpers
 */
class ArrayHelper
{
    /**
     * @param array $orderedFields
     * @param array $value
     * @return mixed
     */
    public static function findValue(array $orderedFields, array $value): mixed
    {
        foreach ($orderedFields as $field) {
            if (!empty($value[$field])) {
                $value = $value[$field];
            } else {
                $value = null;
                break;
            }
        }

        return $value;
    }
}