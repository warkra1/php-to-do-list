<?php

namespace Warkrai\ToDoItem\Repository\Exception;

use Warkrai\ToDoItem\Core\Exception\AppException;

class ModelNotFoundException extends AppException
{
    public static function create(): static
    {
        return new static('Model not found!');
    }
}