<?php

namespace App\Traits;

use Doctrine\Common\Collections\Collection;

trait JsonSerializableTrait
{
    public static $IGNORE_PREFIX = '_';

    public function jsonSerialize(): array
    {
        $variables = get_object_vars($this);

        $result = [];

        foreach ($variables as $key => $value) {
            if (substr($key, 0, 1) === self::$IGNORE_PREFIX) {
                continue;
            }

            if ($value instanceof Collection) {
                $value = $value->toArray();
            }

            $result[self::camelCaseToUnderscore($key)] = $value;
        }

        return $result;
    }

    public static function camelCaseToUnderscore($input): string
    {
        return strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $input));
    }
}
