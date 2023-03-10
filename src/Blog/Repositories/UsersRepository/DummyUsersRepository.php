<?php

namespace GeekBrains\LevelTwo\Blog\Repositories\UsersRepository;

use GeekBrains\LevelTwo\Blog\Exceptions\UserNotFoundException;
use GeekBrains\LevelTwo\Blog\Name;
use GeekBrains\LevelTwo\Blog\User;
use GeekBrains\LevelTwo\Blog\UUID;

class DummyUsersRepository implements UsersRepositoryInterface
{
    public function save(User $user): void
    {
    // Ничего не делаем
    }

    /**
     * @throws UserNotFoundException
     */
    public function get(UUID $uuid): User
    {
    // И здесь ничего не делаем
        throw new UserNotFoundException("Not found");
    }

    /**
     * @throws \GeekBrains\LevelTwo\Blog\Exceptions\InvalidArgumentException
     */
    public function getByUsername(string $username): User
    {
    // Нас интересует реализация только этого метода
    // Для нашего теста не важно, что это будет за пользователь,
    // поэтому возвращаем совершенно произвольного
        return new User(UUID::random(), "user123", new Name("first", "last"));
    }

}