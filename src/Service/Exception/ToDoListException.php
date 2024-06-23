<?php

namespace Warkrai\ToDoItem\Service\Exception;

use Warkrai\ToDoItem\Core\Exception\AppException;

class ToDoListException extends AppException
{
    public static function invalidNumber(): static
    {
        return new static('Invalid item number!');
    }
}