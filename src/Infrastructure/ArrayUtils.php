<?php

namespace Warkrai\ToDoItem\Infrastructure;

class ArrayUtils
{
    public static function arrayInsert(array &$array, $key, $value, $position): void
    {
        $part1 = array_slice($array, 0, $position, true);
        $part2 = array_slice($array, $position, null, true);
        $part1[$key] = $value;
        $array = array_merge($part1, $part2);
    }

    public static function unsetByKey(array &$array, $key): void
    {
        if (array_key_exists($key, $array)) {
            unset($array[$key]);

            $array = array_merge($array);
        }
    }
}