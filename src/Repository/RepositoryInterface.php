<?php

namespace Warkrai\ToDoItem\Repository;

use Warkrai\ToDoItem\Model\ModelInterface;

interface RepositoryInterface
{
    public function read(string $id): ModelInterface;

    public function write(string $id, ModelInterface $model): void;
}