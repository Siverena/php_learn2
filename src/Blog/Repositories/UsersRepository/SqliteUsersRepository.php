<?php

namespace GeekBrains\LevelTwo\Blog\Repositories\UsersRepository;

use GeekBrains\LevelTwo\Blog\Name;
use GeekBrains\LevelTwo\Blog\User;
use GeekBrains\LevelTwo\Blog\Exceptions\UserNotFoundException;
use GeekBrains\LevelTwo\Blog\Exceptions\InvalidArgumentException;
use GeekBrains\LevelTwo\Blog\UUID;
use \PDO;
use PDOStatement;

class SqliteUsersRepository implements UsersRepositoryInterface
{
    private PDO $connection;
    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @param User $user
     */
    public function save(User $user): void
    {
        $statement = $this->connection->prepare(
            'INSERT INTO users (uuid, first_name, last_name, username) VALUES (:uuid, :first_name, :last_name, :username)'
        );
        $statement-> execute([
            ':uuid' => $user->uuid(),
            ':first_name' => $user->name()->first(),
            ':last_name' => $user->name()->last(),
            ':username' => $user->username()
        ]);
    }

    /**
     * @param UUID $uuid
     * @return User
     * @throws InvalidArgumentException
     * @throws UserNotFoundException
     */
    public function get(UUID $uuid): User
    {
        $statement = $this->connection->prepare(
            'SELECT * FROM users WHERE uuid = :uuid'
        );
        $statement->execute([
            ':uuid' => (string)$uuid,
        ]);
        return $this->getUser($statement, $uuid);
    }


    /**
     * @param string $username
     * @return User
     * @throws InvalidArgumentException
     * @throws UserNotFoundException
     */
    public function getByUsername(string $username): User
    {
        $statement = $this->connection->prepare(
            'SELECT * FROM users WHERE username = :username'
        );
        $statement->execute([
            ':username' => $username
        ]);
        return $this->getUser($statement, $username);
    }

    /**
     * @param PDOStatement $statement
     * @param string $param
     * @return User
     * @throws InvalidArgumentException
     * @throws UserNotFoundException
     */
    public function getUser(PDOStatement $statement, string $param): User
    {
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        if ($result === false) {
            throw new UserNotFoundException(
                "Cannot find user: $param"
            );
        }
        return new User(
            new UUID($result['uuid']),
            $result['username'],
            new Name($result['first_name'], $result['last_name'])
        );
    }
}