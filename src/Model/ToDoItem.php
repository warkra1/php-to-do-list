<?php

namespace Warkrai\ToDoItem\Model;

class ToDoItem implements ModelInterface
{
    public function __construct(private string $title) {}

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function jsonSerialize(): array
    {
        return [
            'title' => $this->title,
        ];
    }
}