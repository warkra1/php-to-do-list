<?php

namespace Warkrai\ToDoItem\Model;

class ToDoList implements ModelInterface
{
    /**
     * @param ToDoItem[] $items
     */
    public function __construct(private array $items) {}

    /**
     * @return ToDoItem[]
     */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * @param ToDoItem[] $items
     */
    public function setItems(array $items): void
    {
        $this->items = $items;
    }

    public function jsonSerialize(): array
    {
        return [
            'items' => $this->items,
        ];
    }
}