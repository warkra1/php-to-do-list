<?php

namespace Warkrai\ToDoItem\Repository;

use Warkrai\ToDoItem\Model\ModelInterface;
use Warkrai\ToDoItem\Repository\Exception\ModelNotFoundException;

abstract class AbstractFileRepository implements RepositoryInterface
{
    public function __construct(private string $path) {}

    /**
     * @throws ModelNotFoundException
     */
    public function read(string $id): ModelInterface
    {
        $filename = $this->path . '/' . $id . '.json';
        if (!file_exists($filename)) {
            throw new ModelNotFoundException();
        }

        return $this->unserialize(json_decode(file_get_contents($filename), true));
    }

    public function write(string $id, ModelInterface $model): void
    {
        $filename = $this->path . '/' . $id . '.json';
        file_put_contents($filename, json_encode($model));
    }

    abstract protected function unserialize(array $data): ModelInterface;
}