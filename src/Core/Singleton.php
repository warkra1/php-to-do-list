<?php

namespace Warkrai\ToDoItem\Core;

abstract class Singleton
{
    private static $instances = [];

    protected function __construct() {}

    protected function __clone() {}

    public function __wakeup() {
        throw new \RuntimeException("Cannot unserialize singleton");
    }

    public static function getInstance(): static
    {
        $cls = static::class;
        if (!isset(static::$instances[$cls])) {
            static::$instances[$cls] = new static();
        }

        return static::$instances[$cls];
    }
}