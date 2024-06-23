<?php

namespace Warkrai\ToDoItem\Core\Exception;

abstract class AppException extends \Exception
{
    public static function fromThrowable(\Throwable $t): static
    {
        return new static($t->getMessage(), $t->getCode(), $t);
    }
}