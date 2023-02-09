<?php
namespace GeekBrains\LevelTwo\Blog;

class User
{
    private int $id;
    private string $firstName;
    private string $lastName;
    private string $login;

    /**
     * @param int $id
     * @param string $firstName
     * @param string $lastName
     * @param string $login
     */
    public function __construct(int $id, string $firstName, string $lastName, string $login)
    {
        $this->id = $id;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->login = $login;
    }

    public function __toString(): string
    {
        return $this->firstName . " " . $this->lastName;
    }

    /**
     * @return int
     */
    public function id(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     */
    public function setFirstName(string $firstName): void
    {
        $this->firstName = $firstName;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     */
    public function setLastName(string $lastName): void
    {
        $this->lastName = $lastName;
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