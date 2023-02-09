<?php

namespace GeekBrains\LevelTwo\Blog\Repositories\UsersRepository;

use GeekBrains\LevelTwo\Blog\User;
use GeekBrains\LevelTwo\Blog\UUID;

interface UsersRepositoryInterface
{
    /**
     * @param User $user
     */
    public function save(User $user): void;

    /**
     * @param UUID $uuid
     * @return User
     */
    public function get(UUID $uuid): User;

    /**
     * @param string $username
     * @return User
     */
    public function getByUsername(string $username): User;
}