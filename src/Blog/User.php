<?php
namespace GeekBrains\LevelTwo\Blog;

class User
{
    private UUID $uuid;
    private Name $name;
    private string $username;

    /**
     * @param UUID $uuid
     * @param Name $name
     * @param string $username
     */
    public function __construct(UUID $uuid, string $username, Name $name)
    {
        $this->uuid = $uuid;
        $this->username = $username;
        $this->name = $name;
    }

    public function __toString(): string
    {
        return "Пользователь $this->name с ID $this->uuid и $this->username";
    }

    /**
     * @return UUID
     */
    public function uuid(): UUID
    {
        return $this->uuid;
    }

    /**
     * @return Name
     */
    public function name(): Name
    {
        return $this->name;
    }

    /**
     * @param Name $name
     */
    public function setName(Name $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function username(): string
    {
        return $this->username;
    }

    /**
     * @param string $username
     */
    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

}