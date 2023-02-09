<?php

namespace GeekBrains\LevelTwo\Blog;


class Post
{
    private UUID $uuid;
    private UUID $author;
    private string $title;
    private string $text;

    /**
     * @param UUID $uuid
     * @param UUID $author
     * @param string $title
     * @param string $text
     */
    public function __construct(UUID $uuid, UUID $author, string $title, string $text)
    {
        $this->uuid = $uuid;
        $this->author = $author;
        $this->title = $title;
        $this->text = $text;
    }

    public function __toString(): string
    {
        return $this->title . " >>> " . $this->text;
    }

    /**
     * @return UUID
     */
    public function uuid(): UUID
    {
        return $this->uuid;
    }

    /**
     * @return UUID
     */
    public function getAuthor(): UUID
    {
        return $this->author;
    }

    /**
     * @param UUID $author
     */
    public function setAuthor(UUID $author): void
    {
        $this->author = $author;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @param string $text
     */
    public function setText(string $text): void
    {
        $this->text = $text;
    }


}