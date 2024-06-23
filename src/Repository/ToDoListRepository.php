<?php

namespace Warkrai\ToDoItem\Repository;

use Warkrai\ToDoItem\Model\ToDoItem;
use Warkrai\ToDoItem\Model\ToDoList;

class ToDoListRepository extends AbstractFileRepository
{
    public function read(string $id): ToDoList
    {
        /** @var ToDoList $list */
        $list = parent::read($id);
        return $list;
    }

    protected function unserialize(array $data): ToDoList
    {
        $items = [];
        foreach ($data['items'] as $item) {
            $items[] = new ToDoItem($item['title']);
        }
        return new ToDoList($items);
    }
}