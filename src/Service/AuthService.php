<?php

namespace Warkrai\ToDoItem\Service;

use Warkrai\ToDoItem\Infrastructure\PasswordHasher;
use Warkrai\ToDoItem\Model\User;
use Warkrai\ToDoItem\Repository\Exception\ModelNotFoundException;
use Warkrai\ToDoItem\Repository\UserRepository;
use Warkrai\ToDoItem\Service\Exception\AuthException;

class AuthService
{
    private ?User $user = null;

    public function __construct(private UserRepository $repository) {}

    public function getCurrentUser(): ?User
    {
        return $this->user;
    }

    /**
     * @throws AuthException
     */
    public function login(string $login, string $password): void
    {
        try {
            $user = $this->repository->read($login);
        } catch (ModelNotFoundException) {
            throw AuthException::userNotFound();
        }

        if (!PasswordHasher::checkPassword($user, $password)) {
            throw AuthException::invalidPassword();
        }

        $this->user = $user;
    }

    /**
     * @throws AuthException
     */
    public function register(string $login, string $password): void
    {
        if ($this->repository->exists($login)) {
            throw AuthException::userAlreadyExists();
        }

        $user = new User($login, PasswordHasher::hashPassword($password));
        $this->repository->write($login, $user);
        $this->user = $user;
    }
}