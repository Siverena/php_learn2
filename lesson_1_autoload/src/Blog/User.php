<?php
namespace GeekBrains\LevelTwo\Blog;

use GeekBrains\LevelTwo\Person\Name;

class User
{
    private int $id;
    private Name $username;
    private string $login;

    /**
     * @param int $id
     * @param string $username
     * @param string $login
     */
    public function __construct(int $id, Name $username, string $login)
    {
        $this->id = $id;
        $this->username = $username;
        $this->login = $login;
    }

    public function __toString(): string
    {
        return "Юзер $this->id с именем $this->username и логином $this->login." . PHP_EOL;
    }

    /**
     * @return int
     */
    public function id(): int
    {
        return $this->id;
    }

    /**
     * @return Name|string
     */
    public function getUsername(): Name|string
    {
        return $this->username;
    }

    /**
     * @param Name|string $username
     */
    public function setUsername(Name|string $username): void
    {
        $this->username = $username;
    }

    /**
     * @return string
     */
    public function getLogin(): string
    {
        return $this->login;
    }

    /**
     * @param string $login
     */
    public function setLogin(string $login): void
    {
        $this->login = $login;
    }

}