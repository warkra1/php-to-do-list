<?php

namespace Warkrai\ToDoItem\Service;

use Warkrai\ToDoItem\Infrastructure\PasswordHasher;
use Warkrai\ToDoItem\Model\User;
use Warkrai\ToDoItem\Repository\Exception\ModelNotFoundException;
use Warkrai\ToDoItem\Repository\RepositoryInterface;
use Warkrai\ToDoItem\Repository\UserRepository;
use Warkrai\ToDoItem\Service\Exception\AuthException;

class AuthService
{
    private ?User $user = null;

    public function __construct(private RepositoryInterface $repository) {}

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
            /** @var User $user */
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
        if ($this->exists($login)) {
            throw AuthException::userAlreadyExists();
        }

        $user = new User($login, PasswordHasher::hashPassword($password));
        $this->repository->write($login, $user);
        $this->user = $user;
    }

    private function exists(string $login): bool {
        try {
            $this->repository->read($login);
            return true;
        } catch (ModelNotFoundException) {
            return false;
        }
    }
}