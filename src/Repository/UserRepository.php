<?php

namespace Warkrai\ToDoItem\Repository;

use Warkrai\ToDoItem\Model\ModelInterface;
use Warkrai\ToDoItem\Model\User;
use Warkrai\ToDoItem\Repository\Exception\ModelNotFoundException;

class UserRepository extends AbstractFileRepository
{
    public function read(string $id): User
    {
        /** @var User $user */
        $user = parent::read($id);
        return $user;
    }

    protected function unserialize(array $data): User
    {
        return new User($data['login'], $data['password']);
    }
}