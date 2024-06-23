<?php

namespace Warkrai\ToDoItem\Model;

class User implements ModelInterface
{
    public function __construct(
        private string $login,
        private string $password,
    ) {}

    public function getLogin(): string
    {
        return $this->login;
    }

    public function setLogin(string $login): void
    {
        $this->login = $login;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function jsonSerialize(): array
    {
        return [
            'login' => $this->login,
            'password' => $this->password,
        ];
    }
}