<?php

namespace GeekBrains\LevelTwo\Blog;


class Post
{
    private int $id;
    private int $author;
    private string $header;
    private string $text;

    /**
     * @param int $id
     * @param int $author
     * @param string $header
     * @param string $text
     */
    public function __construct(int $id, int $author, string $header, string $text)
    {
        $this->id = $id;
        $this->author = $author;
        $this->header = $header;
        $this->text = $text;
    }

    public function __toString(): string
    {
        return $this->header . " >>> " . $this->text;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getAuthor(): int
    {
        return $this->author;
    }

    /**
     * @param int $author
     */
    public function setAuthor(int $author): void
    {
        $this->author = $author;
    }

    /**
     * @return string
     */
    public function getHeader(): string
    {
        return $this->header;
    }

    /**
     * @param string $header
     */
    public function setHeader(string $header): void
    {
        $this->header = $header;
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