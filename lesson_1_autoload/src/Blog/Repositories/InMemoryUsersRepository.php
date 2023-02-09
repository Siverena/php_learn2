<?php

namespace GeekBrains\LevelTwo\Blog\Repositories;

use GeekBrains\LevelTwo\Blog\Exceptions\UserNotFoundException;
use GeekBrains\LevelTwo\Blog\User;

class InMemoryUsersRepository
{
    private array $users = [];

    /**
     * @param User $user
     */
    public function save(User $user): void
    {
        $this->users[] = $user;
    }

    /**
     * @param int $id
     * @return User
     * @throws UserNotFoundException
     */
    public function get(int $id): User
    {
        foreach ($this->users as $user) {
            if ($user->id() === $id) {
                return $user;
            }
        }
        throw new UserNotFoundException("User with ID \"$id\" not found!". PHP_EOL);
    }
}