<?php

namespace Warkrai\ToDoItem;

use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;
use Warkrai\ToDoItem\Core\Singleton;
use Warkrai\ToDoItem\Repository\ToDoListRepository;
use Warkrai\ToDoItem\Repository\UserRepository;
use Warkrai\ToDoItem\Service\AuthService;
use Warkrai\ToDoItem\Service\ToDoListService;

class Container extends Singleton implements ContainerInterface
{
    private array $services;

    public function __construct()
    {
        parent::__construct();

        $this->services[UserRepository::class] = new UserRepository(dirname(__DIR__) . '/data/user');
        $this->services[ToDoListRepository::class] = new ToDoListRepository(
            dirname(__DIR__) . '/data/to_do_list'
        );
        $this->services[AuthService::class] = new AuthService($this->services[UserRepository::class]);
        $this->services[ToDoListService::class] = new ToDoListService($this->services[ToDoListRepository::class]);
        $this->services[CommandProcessor::class] = new CommandProcessor(
            $this->services[AuthService::class],
            $this->services[ToDoListService::class],
        );
    }

    public function get(string $id)
    {
        return $this->services[$id] ?? null;
    }

    public function has(string $id): bool
    {
        return isset($this->services[$id]);
    }
}