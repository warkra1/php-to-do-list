<?php

namespace Warkrai\ToDoItem\Service;

use Warkrai\ToDoItem\Infrastructure\ArrayUtils;
use Warkrai\ToDoItem\Model\ToDoItem;
use Warkrai\ToDoItem\Model\ToDoList;
use Warkrai\ToDoItem\Model\User;
use Warkrai\ToDoItem\Repository\Exception\ModelNotFoundException;
use Warkrai\ToDoItem\Repository\RepositoryInterface;
use Warkrai\ToDoItem\Repository\ToDoListRepository;

class ToDoListService
{
    public function __construct(private RepositoryInterface $repository) {}

    public function getList(User $user): ToDoList
    {
        try {
            /** @var ToDoList $list */
            $list = $this->repository->read($user->getLogin());
            return $list;
        } catch (ModelNotFoundException) {
            return $this->createList($user);
        }
    }

    public function createItem(User $user, ToDoItem $item, int $number): ToDoList
    {
        $list = $this->getList($user);
        $toDoItems = $list->getItems();
        if ($number > count($toDoItems)) {
            $number = count($toDoItems);
        }

        ArrayUtils::arrayInsert($toDoItems, $number, $item, $number);
        $list->setItems($toDoItems);
        $this->repository->write($user->getLogin(), $list);
        return $list;
    }

    public function updateItem(User $user, ToDoItem $item, int $number): ToDoList
    {
        $list = $this->getList($user);
        $items = $list->getItems();
        if (isset($items[$number])) {
            $items[$number] = $item;
        }
        $list->setItems($items);
        $this->repository->write($user->getLogin(), $list);
        return $list;
    }

    public function deleteItem(User $user, int $number): ToDoList
    {
        $list = $this->getList($user);
        $items = $list->getItems();
        ArrayUtils::unsetByKey($items, $number);
        $list->setItems($items);
        $this->repository->write($user->getLogin(), $list);
        return $list;
    }

    private function createList(User $user): ToDoList
    {
        $list = new ToDoList([]);
        $this->repository->write($user->getLogin(), $list);
        return $list;
    }
}