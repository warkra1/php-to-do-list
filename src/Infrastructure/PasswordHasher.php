<?php

namespace Warkrai\ToDoItem\Infrastructure;

use Warkrai\ToDoItem\Model\User;

class PasswordHasher
{
    public static function hashPassword(string $password): string
    {
        return md5($password);
    }

    public static function checkPassword(User $user, string $password): bool
    {
        return $user->getPassword() === static::hashPassword($password);
    }
}