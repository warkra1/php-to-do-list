<?php

namespace Warkrai\ToDoItem;

use JetBrains\PhpStorm\NoReturn;
use Warkrai\ToDoItem\Model\ToDoItem;
use Warkrai\ToDoItem\Service\AuthService;
use Warkrai\ToDoItem\Service\Exception\AuthException;
use Warkrai\ToDoItem\Service\ToDoListService;

class CommandProcessor
{
    public function __construct(
        private AuthService $authService,
        private ToDoListService $toDoListService,
    ) {}

    #[NoReturn]
    public function run(): void
    {
        echo "Hello, this is a to do list CLI App" . PHP_EOL;

        while (true) {
            $ans = readline('Please, Enter a command (or type "help" to see all commands): ');
            $command = Commands::tryFrom($ans);

            switch ($command) {
                case Commands::LOGIN:
                    $this->login();
                    break;
                case Commands::REGISTER:
                    $this->register();
                    break;
                case Commands::GET_LIST:
                    $this->getList();
                    break;
                case Commands::CREATE_ITEM:
                    $this->createItem();
                    break;
                case Commands::UPDATE_ITEM:
                    $this->updateItem();
                    break;
                case Commands::DELETE_ITEM:
                    $this->deleteItem();
                    break;
                case Commands::HELP:
                    $this->help();
                    break;
                case Commands::EXIT:
                    $this->appExit();
                default:
                    echo "Invalid command!" . PHP_EOL;
            }
        }
    }

    private function checkAuth(): bool
    {
        if (is_null($this->authService->getCurrentUser())) {
            echo "You should login first!" . PHP_EOL;
            return false;
        }

        return true;
    }

    private function login(): void
    {
        $login = readline('Enter login: ');
        $password = readline('Enter password: ');
        try {
            $this->authService->login($login, $password);
            echo 'Successfully logged in!' . PHP_EOL;
        } catch (AuthException $e) {
            echo $e->getMessage() . PHP_EOL;
        }
    }

    private function register(): void
    {
        $login = readline('Enter login: ');
        $password = readline('Enter password: ');
        try {
            $this->authService->register($login, $password);
            echo "Successfully registered!" . PHP_EOL;
        } catch (AuthException $e) {
            echo $e->getMessage() . PHP_EOL;
        }
    }

    private function getList(): void
    {
        if (!$this->checkAuth()) {
            return;
        }

        $list = $this->toDoListService->getList($this->authService->getCurrentUser());
        echo 'To Do List:' . PHP_EOL;
        if (empty($list->getItems())) {
            echo "\tYour list is empty" . PHP_EOL;
        } else {
            foreach ($list->getItems() as $key => $item) {
                echo "\t[" . $key + 1 . "] " . $item->getTitle() . PHP_EOL;
            }
        }
    }

    private function createItem(): void
    {
        if (!$this->checkAuth()) {
            return;
        }

        $title = readline('Enter title: ');
        $number = $this->askNumber('Enter number: ');

        $this->toDoListService->createItem(
            $this->authService->getCurrentUser(),
            new ToDoItem($title),
            $number - 1,
        );

        echo "Item successfully created!" . PHP_EOL;
    }

    private function updateItem(): void
    {
        if (!$this->checkAuth()) {
            return;
        }

        $number = $this->askNumber('Enter a number of item: ');
        $title = readline('Enter new title: ');

        $this->toDoListService->updateItem(
            $this->authService->getCurrentUser(),
            new ToDoItem($title),
            $number - 1,
        );

        echo "Item successfully updated!" . PHP_EOL;
    }

    private function deleteItem(): void
    {
        if (!$this->checkAuth()) {
            return;
        }

        $number = $this->askNumber('Enter a number of item: ');
        $this->toDoListService->deleteItem($this->authService->getCurrentUser(), $number - 1);
        echo "Item successfully deleted!" . PHP_EOL;
    }

    private function help(): void
    {
        echo 'List of commands:' . PHP_EOL;
        echo "\t" . Commands::LOGIN->value . ' - authorize to application' . PHP_EOL;
        echo "\t" . Commands::REGISTER->value . ' - create new user' . PHP_EOL;
        echo "\t" . Commands::GET_LIST->value . ' - get current user\'s todo list' . PHP_EOL;
        echo "\t" . Commands::CREATE_ITEM->value . ' - create a new item in todo list' . PHP_EOL;
        echo "\t" . Commands::UPDATE_ITEM->value . ' - updates a specific item in list' . PHP_EOL;
        echo "\t" . Commands::DELETE_ITEM->value . ' - deletes a specific item in list' . PHP_EOL;
        echo "\t" . Commands::HELP->value . ' - show commands' . PHP_EOL;
        echo "\t" . Commands::EXIT->value . ' - exit from application' . PHP_EOL;
    }

    #[NoReturn]
    private function appExit(): void
    {
        echo "Bye!" . PHP_EOL;
        exit();
    }

    private function askNumber(string $message): int
    {
        while (true) {
            $number = readline($message);
            if (is_numeric($number)) {
                return (int) $number;
            }

            echo 'Invalid number!' . PHP_EOL;
        }
    }
}