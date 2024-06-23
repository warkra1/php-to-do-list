<?php

namespace Warkrai\ToDoItem\Service\Exception;

use Warkrai\ToDoItem\Core\Exception\AppException;

class AuthException extends AppException
{
    public static function userNotFound(): static
    {
        return new static("User not found!");
    }

    public static function invalidPassword(): static
    {
        return new static("Invalid password!");
    }

    public static function userAlreadyExists(): static
    {
        return new static("User already exists!");
    }
}